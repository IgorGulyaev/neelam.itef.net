<?php

class Mageplaza_BannerSlider_Adminhtml_AdvancesliderController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('bannerslider/advanceslider')
            ->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Manage Advanced Slider'),
                Mage::helper('adminhtml')->__('Advanced Slider')
            );
        $this->_title($this->__('Banner Slider'))->_title('Advanced Slider');

        return $this;
    }


    /**
     * index action
     */
    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }


    /**
     *
     *
     */
    public function loadDataAction()
    {
        $value         = $this->getRequest()->getParam('select_value');
        $sliderAdvance = Mage::getModel('bannerslider/advanceslider')->load($value)->getData();
        $this->_bodyResponse(Mage::helper('core')->jsonEncode($sliderAdvance));

        return;
    }

    /**
     * Body Ajax Response
     *
     * @param $data
     */
    protected function _bodyResponse($data)
    {
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data));
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function editAction()
    {
        $advanceIds = $this->getRequest()->getParam('id');
        $model      = Mage::getModel('bannerslider/advanceslider')->load($advanceIds);

        if ($model->getId() || $advanceIds == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('advanceslider_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('bannerslider/advanceslider');

            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Item Manager'),
                Mage::helper('adminhtml')->__('Item Manager')
            );
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Item News'),
                Mage::helper('adminhtml')->__('Item News')
            );
            $this->_title($this->__('Banner Slider'))->_title('Advanced Slider');
            //			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true)
                ->setCanLoadRulesJs(true);
            $this->_addContent($this->getLayout()->createBlock('bannerslider/adminhtml_advanceslider_edit'))
                ->_addLeft($this->getLayout()->createBlock('bannerslider/adminhtml_advanceslider_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bannerslider')->__('Item does not exist')
            );
            $this->_redirect('*/*/');
        }
    }


    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $sliderId      = $this->getRequest()->getParam('id');
            $advanceSlider = Mage::getModel('bannerslider/advanceslider')->load($sliderId);
            try {
                $bannerHtml          = Mage::helper('core')->jsonEncode($data['banner_html']);
                $data['banner_html'] = $bannerHtml;
                $validateResult      = $advanceSlider->validateData(new Varien_Object($data));
                if ($validateResult !== true) {
                    foreach ($validateResult as $errorMessage) {
                        $this->_getSession()->addError($errorMessage);
                    }
                    $this->_getSession()->setSliderData($data);

                    return;
                }
                if (isset($data['rule']['conditions'])) {
                    $data['conditions'] = $data['rule']['conditions'];
                }

                unset($data['rule']);
                $advanceSlider->loadPost($data);
                $this->_getSession()->setSliderData($advanceSlider->getData());
                if(!$advanceSlider->getIsDefault())
                $advanceSlider->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bannerslider')->__('Item was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back', false)) {
                    $this->_redirect('*/*/edit', array('id' => $advanceSlider->getId(), '_current' => true));

                    return;
                }
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bannerslider')->__('Unable to find item to save')
        );
        $this->_redirect('*/*/');
    }


    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('bannerslider/advanceslider');
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Item was successfully deleted')
                );
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massStatusAction()
    {
        $advanceIds = $this->getRequest()->getParam('bannerslider');
        if (!is_array($advanceIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($advanceIds as $bannerAdvanceId) {
                    Mage::getSingleton('bannerslider/advanceslider')
                        ->load($bannerAdvanceId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($advanceIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        $advanceIds = $this->getRequest()->getParam('bannerslider');

        if (!is_array($advanceIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($advanceIds as $advanceId) {
                    $advanceSlider = Mage::getModel('bannerslider/advanceslider')->load($advanceId);
                    $advanceSlider->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted',
                        count($advanceIds))
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
            ->createBlock('bannerslider/adminhtml_advanceslider_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export grid item to XML type
     */
    public function exportXmlAction()
    {
        $fileName = 'advanceslider.xml';
        $content  = $this->getLayout()
            ->createBlock('bannerslider/adminhtml_advanceslider_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function previewAction()
    {
        $this->_title($this->__('Banner Slider'))->_title('Preview');
        $this->loadLayout()
            ->renderLayout();
    }

    public function newConditionHtmlAction()
    {
        $id      = $this->getRequest()->getParam('id');
        $typeArr = explode('|', str_replace('-', '/', $this->getRequest()->getParam('type')));
        $type    = $typeArr[0];
        $model   = Mage::getModel($type)
            ->setId($id)
            ->setType($type)
            ->setRule(Mage::getModel('bannerslider/advanceslider'))
            ->setPrefix('conditions');
        if (!empty($typeArr[1])) {
            $model->setAttribute($typeArr[1]);
        }

        if ($model instanceof Mage_Rule_Model_Condition_Abstract) {
            $model->setJsFormObject($this->getRequest()->getParam('form'));
            $html = $model->asHtmlRecursive();
        } else {
            $html = '';
        }
        $this->getResponse()->setBody($html);
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('bannerslider/advanceslider');
    }
}