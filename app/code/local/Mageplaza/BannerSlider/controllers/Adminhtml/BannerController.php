<?php
class Mageplaza_BannerSlider_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('bannerslider/banner')
            ->_addBreadcrumb($this->__('Banner Manager'), $this->__('Banner Manager'));

        return $this;
    }

    public function indexAction()
    {

        $this->_title($this->__('bannerslider'))->_title($this->__('Manage Banner'));
        $this->_initAction()
            ->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function _initBanner()
    {
        $bannerId = (int)$this->getRequest()->getParam('id');
        $banner   = Mage::getModel('bannerslider/banner');

        if ($bannerId) {
            $banner->load($bannerId);
            if (!$banner->getId()) {
                $this->_getSession()->addError($this->__('This Banner no longer exists.'));
                $this->_redirect('*/*/');
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);

                return false;
            }
        }

        return $banner;
    }

    public function editAction()
    {
        $this->_title($this->__('bannerslider'))->_title($this->__('Manage Banner'));

        if ($banner = $this->_initBanner()) {
            $data = $this->_getSession()->getBannerData(true);
            if (!empty($data)) {
                $banner->setData($data);
            }
            Mage::register('current_banner', $banner);

            $this->_initAction()
                ->_title($banner->getId() ? $banner->getBannerId() : $this->__('New Banner'))
                ->_addBreadcrumb(
                    $banner->getBannerId() ? $this->__('Edit Banner') : $this->__('New Banner'),
                    $banner->getBannerId() ? $this->__('Edit Banner') : $this->__('New Banner')
                );

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('bannerslider/adminhtml_banner_edit'))
                ->_addLeft($this->getLayout()->createBlock('bannerslider/adminhtml_banner_edit_tabs'));

            $this->renderLayout();
        }
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('id', '');
            if (isset($data['image']['delete'])) {
                $data['image'] = '';
            } else {
                if (isset($_FILES['source_file']['name']) && $_FILES['source_file']['name'] != '') {
                    try {
                        $uploader = new Varien_File_Uploader('source_file');

                        if ($data['type_id'] == 1) {
                            $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));

                        } else if ($data['type_id'] == 2) {
                            $uploader->setAllowedExtensions(array('swf'));
                        }
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);
                        $path = Mage::getBaseDir('media') . DS . 'mageplaza' . DS . 'bannerslider' . DS . 'banner' . DS;
                        $file = $uploader->save($path, $_FILES['source_file']['name']);

                    } catch (Exception $e) {
                        $this->_getSession()->addError($this->__('Please select correct type of banner: Image(.jpg, .jpeg, .png, .gif), Flash (.swf)'));
                        $this->_redirect('*/*/edit', array('id' => $id));
                        Mage::getSingleton('adminhtml/session')->setFormData($data);

                        return $this;
                    }
                    $data['source_file'] = $file['file'];
                } else {
                    unset($data['image']);
                }
                if ($data) {
                    if ($data['type_id'] != 1 && $data['type_id'] != 2) {
                        ($data['width'] = 0);
                        ($data['height'] = 0);
                        ($data['source_file'] = '');
                    }
                    if ($data['fix_size'] != 1) {
                        $data['width']  = 0;
                        $data['height'] = 0;

                    }

                    $bannerId = $this->getRequest()->getParam('id');
                    $banner   = Mage::getModel('bannerslider/banner');
                    $banner->setData($data)->setId($bannerId);
                    try {
                        $banner->save();
                        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bannerslider')->__('The banner has been saved successfully.'));
                        Mage::getSingleton('adminhtml/session')->setFormData(false);
                        if ($this->getRequest()->getParam('back')) {
                            $this->_redirect('*/*/edit', array('id' => $banner->getId()));

                            return;
                        }
                        $this->_redirect('*/*/');

                        return;
                    } catch (Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                        Mage::getSingleton('adminhtml/session')->setFormData($data);
                        $this->_redirect('*/*/');

                        return;
                    }
                }
                $this->_redirect('*/*/');
            }
        }
    }

    public function deleteAction()
    {
        $account = $this->_initBanner();
        if ($account->getId()) {
            try {
                $account->delete();
                $this->_getSession()->addSuccess($this->__('Delete successfully'));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function deleteFileAction()
    {
        $bannerId   = $this->getRequest()->getParam('banner_id');
        $sourceFile = $this->getRequest()->getParam('source_file');
        $banner     = Mage::getModel('bannerslider/banner')->load($bannerId);
        if ($banner && $banner->getId()) {
            $banner->setData('source_file', '');
            $banner->save();
            Mage::helper('bannerslider')->deleteFile($sourceFile);
        }
        $this->_getSession()->addSuccess($this->__('Delete file successfully'));
        $this->_redirect('*/*/edit', array('id' => $bannerId));
    }

    public function massStatusAction()
    {
        $bannerIds = $this->getRequest()->getParam('banner');
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select banner(s)'));
        } else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $banner = Mage::getSingleton('bannerslider/banner')
                        ->load($bannerId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($bannerIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        $bannerIds = $this->getRequest()->getParam('banner');
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select banner(s)'));
        } else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $banner = Mage::getModel('bannerslider/banner')->load($bannerId);
                    $banner->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($bannerIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName = 'banner.csv';
        $content  = $this->getLayout()
            ->createBlock('bannerslider/adminhtml_banner_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export grid item to XML type
     */
    public function exportXmlAction()
    {
        $fileName = 'banner.xml';
        $content  = $this->getLayout()
            ->createBlock('bannerslider/adminhtml_banner_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('bannerslider/banner');
    }
}