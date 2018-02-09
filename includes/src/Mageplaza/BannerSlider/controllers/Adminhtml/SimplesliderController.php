<?php

class Mageplaza_BannerSlider_Adminhtml_SimplesliderController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('bannerslider/simpleslider')
            ->_addBreadcrumb($this->__('Simple Slider Manager'), $this->__('Simple Slider Manager'));

        return $this;
    }

    public function carouselAction()
    {
        $this->_title($this->__('Banner Slider'))->_title($this->__('Carouse Sliders'));

        if ($this->getRequest()->getParam('ajax')) {
            Mage::register('useCarouselFilter', true);

            return $this->_forward('grid');
        }
        Mage::register('useCarouselFilter', true);
        $this->_initAction()
            ->renderLayout();
    }

    public function gridAction()
    {
        $this->_initAction()
            ->renderLayout();
    }

    public function popupAction()
    {
        $this->_title($this->__('Banner Slider'))->_title($this->__('Popup Sliders'));

        if ($this->getRequest()->getParam('ajax')) {
            Mage::register('usePopupFilter', true);

            return $this->_forward('grid');
        }
        Mage::register('usePopupFilter', true);
        $this->_initAction()
            ->renderLayout();
    }

    public function noteAction()
    {
        $this->_title($this->__('Slider Note'))->_title($this->__('Manage Slider'));

        if ($this->getRequest()->getParam('ajax')) {
            Mage::register('useNoteFilter', true);

            return $this->_forward('grid');
        }
        Mage::register('useNoteFilter', true);
        $this->_initAction()
            ->renderLayout();
    }

    public function flexAction()
    {
        $this->_title($this->__('Banner Slider'))->_title($this->__('Flex Sliders'));

        if ($this->getRequest()->getParam('ajax')) {
            Mage::register('useFlexFilter', true);

            return $this->_forward('grid');
        }
        Mage::register('useFlexFilter', true);
        $this->_initAction()
            ->renderLayout();
    }

    public function massStatusAction()
    {
        $simplesliderIds = $this->getRequest()->getParam('simpleslider');
        if (!is_array($simplesliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Slider(s)'));
        } else {
            try {
                foreach ($simplesliderIds as $simplesliderId) {
                    $simpleslider = Mage::getSingleton('bannerslider/simpleslider')
                        ->load($simplesliderId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($simplesliderIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/' . $this->getRequest()->getParam('type', 'index'));

    }

    public function massDeleteAction()
    {
        $sliderIds = $this->getRequest()->getParam('simpleslider');
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select slider(s)'));
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getModel('bannerslider/simpleslider')->load($sliderId);
                    $slider->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($sliderIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/' . $this->getRequest()->getParam('type', 'index'));

    }

    public function exportCsvAction()
    {
        $fileName = 'simpleslider.csv';
        $content  = $this->getLayout()
            ->createBlock('bannerslider/adminhtml_simpleslider_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export grid item to XML type
     */
    public function exportXmlAction()
    {
        $fileName = 'simpleslider.xml';
        $content  = $this->getLayout()
            ->createBlock('bannerslider/adminhtml_simpleslider_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function _initSlider()
    {
        $sliderId = (int)$this->getRequest()->getParam('id');

        $slider = Mage::getModel('bannerslider/simpleslider');

        if ($sliderId) {
            $slider->load($sliderId);
            if (!$slider->getId()) {
                $this->_getSession()->addError($this->__('This slider no longer exists.'));
                $this->_redirect('*/*/');
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);

                return false;
            }
        }

        return $slider;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        if ($slider = $this->_initSlider()) {
            $data = $this->_getSession()->getSimplesliderData(true);
            if (!empty($data)) {
                $slider->setData($data);
            }
            Mage::register('current_simpleslider', $slider);
            $this->_initAction()
                ->_title($slider->getId() ? $slider->getBannerId() : $this->__('New Slider'))
                ->_addBreadcrumb(
                    $slider->getBannerId() ? $this->__('Edit Banner') : $this->__('New Slider'),
                    $slider->getBannerId() ? $this->__('Edit Banner') : $this->__('New Slider')
                );
            $this->_title($this->__('Banner Slider'))->_title($this->__('%s Slider', ucfirst($this->getRequest()->getParam('type'))));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true)
                ->setCanLoadRulesJs(true);
            $this->_addContent($this->getLayout()->createBlock('bannerslider/adminhtml_simpleslider_edit'))
                ->_addLeft($this->getLayout()->createBlock('bannerslider/adminhtml_simpleslider_edit_tabs'));

            $this->renderLayout();
        }
    }

    public function deleteAction()
    {
        $slider = $this->_initSlider();
        if ($slider->getId()) {
            try {
                $slider->delete();
                $this->_getSession()->addSuccess($this->__('Delete successfully'));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/' . $this->getRequest()->getParam('type', 'index'));
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $sliderId = $this->getRequest()->getParam('id');
            $type     = $this->getRequest()->getParam('type');
            $slider   = Mage::getModel('bannerslider/simpleslider');
            if ($sliderId) {
                $slider->load($sliderId);
                if ($sliderId != $slider->getId()) {
                    Mage::throwException($this->__('Wrong Slider specified.'));
                }
            }
            try {
                /**
                 * Save config slider
                 */

                $configSlider = array();
                if ($type == 'carousel') {
                    $configSlider = array('autoPlay'   => $data['autoPlay'], 'slideSpeed' => $data['slideSpeed'], 'navigation' => $data['navigation'],
                                          'pagination' => $data['pagination'], 'stopOnHover' => $data['stopOnHover'], 'lazyLoad' => $data['lazyLoad'],
                                          'autoHeight' => $data['autoHeight'], 'mouseDrag' => $data['mouseDrag'], 'touchDrag' => $data['touchDrag'],
                                          'effect'     => $data['effect'], 'addClassActive' => $data['addClassActive']);
                } elseif ($type == 'popup') {
                    $configSlider   = array('autoPlay'  => $data['autoPlay'], 'slideSpeed' => $data['slideSpeed'], 'autoSize' => $data['autoSize'], 'autoResize' => $data['autoResize'],
                                            'fitToView' => $data['fitToView'], 'showNavigation' => $data['showNavigation'], 'openEffect' => $data['openEffect'], 'closeEffect' => $data['closeEffect'], 'prevEffect' => $data['prevEffect'], 'nextEffect' => $data['nextEffect']);
                    $pageView       = implode("%", $data['pageview']);
                    $extend         = array('pageview' => $pageView);
                    $data['extend'] = Mage::helper('core')->jsonEncode($extend);
                } elseif ($type == 'note') {

                } elseif ($type == 'flex') {
                    $configSlider = array('reverse'   => $data['reverse'], 'animationLoop' => $data['animationLoop'], 'smoothHeight' => $data['smoothHeight'],
                                          'slideshow' => $data['slideshow'], 'slideshowSpeed' => $data['slideshowSpeed'], 'randomize' => $data['randomize'],
                                          'useCSS'    => $data['useCSS'], 'minItems' => $data['minItems'], 'maxItems' => $data['maxItems'], 'animation' => $data['animation']);
                }
                /**
                 * End save config slider
                 */

                if (isset($data['device_992'])) {
                    $configDevice          = array('device_992' => $data['device_992'], 'device_768' => $data['device_768'], 'device_481' => $data['device_481'], 'device_1200' => $data['device_1200'], 'device_less_480' => $data['device_less_480']);
                    $data['device_config'] = Mage::helper('core')->jsonEncode($configDevice);
                }
                $data['slider_config'] = Mage::helper('core')->jsonEncode($configSlider);

                /**
                 * Save Rule
                 */
                $validateResult = $slider->validateData(new Varien_Object($data));
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
                $slider->loadPost($data);

                $this->_getSession()->setSliderData($slider->getData());
                $slider->save();

                if (isset($data['in_banner']) && is_array($data['in_banner'])) {
                    $bannerDetails = Mage::getModel('bannerslider/bannerdetail')->getCollection()
                        ->addFieldToFilter('simple_slider_id', $slider->getId());
                    foreach ($bannerDetails as $item) {
                        $item->delete();
                    }
                    foreach ($data['in_banner'] as $key) {
                        $bannnerDetail = Mage::getModel('bannerslider/bannerdetail');
                        $bannnerDetail->setData(array('simple_slider_id' => $slider->getId(), 'banner_id' => $key, 'order' => $data['order'][$key]));
                        $bannnerDetail->save();
                    }
                } else {
                    $bannerDetails = Mage::getModel('bannerslider/bannerdetail')->getCollection()
                        ->addFieldToFilter('simple_slider_id', $slider->getId());
                    foreach ($bannerDetails as $item) {
                        $item->delete();
                    }
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bannerslider')->__('The Slider has been saved successfully.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $slider->getId(), 'type' => $type));

                    return;
                }
                $this->_redirect('*/*/' . $this->getRequest()->getParam('type', 'index'));

                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/' . $this->getRequest()->getParam('type', 'index'));

                return;
            }
        }
        $this->_redirect('*/*/' . $this->getRequest()->getParam('type', 'index'));
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
            ->setRule(Mage::getModel('bannerslider/simpleslider'))
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
        return Mage::getSingleton('admin/session')->isAllowed('bannerslider/simpleslider');
    }
}
