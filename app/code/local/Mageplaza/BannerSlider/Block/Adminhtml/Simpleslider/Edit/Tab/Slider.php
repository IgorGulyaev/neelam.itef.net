<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Simpleslider_Edit_Tab_Slider extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $slider = Mage::registry('current_simpleslider');
        if (count($slider->getData())) {
            $sliderConfig = Mage::helper('core')->jsonDecode($slider->getSliderConfig());
            $slider->addData($sliderConfig);
            $deviceConfig = Mage::helper('core')->jsonDecode($slider->getDeviceConfig());
            if ($deviceConfig)
                $slider->addData($deviceConfig);
            $extend = Mage::helper('core')->jsonDecode($slider->getExtend());
            if ($extend)
                $slider->addData($extend);
                $slider->setPageview(explode('%',$slider->getData('pageview')));
        }

        if (Mage::getSingleton('adminhtml/session')->getFormData()) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);
            $slider->setData($data);
        }
        $fieldset = $form->addFieldset('simplesliderinfo_form', array(
            'legend' => Mage::helper('bannerslider')->__('General')
        ));
        $fieldset->addField('name', 'text', array(
            'label'    => Mage::helper('bannerslider')->__('Name'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => 'name',

        ));
        $statusArray = Mage::getModel('bannerslider/status')->getOptionArray();

        $fieldset->addField('status', 'select', array(
            'label'  => Mage::helper('bannerslider')->__('Status'),
            'name'   => 'status',
            'values' => $statusArray
        ));
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('bannerslider')->__('Title'),
            'name'  => 'title',
        ));
        $showtitle = Mage::getModel('bannerslider/simpleslider')->getOptionArray();
        $fieldset->addField('enable_title', 'select', array(
            'label'  => Mage::helper('bannerslider')->__('Show Title'),
            'name'   => 'enable_title',
            'values' => $showtitle
        ));
        $fieldset->addField('description', 'textarea', array(
            'label' => Mage::helper('bannerslider')->__('Description'),
            'name'  => 'description',

        ));

        $store = Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false);

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name'     => 'stores[]',
                'label'    => Mage::helper('bannerslider')->__('Store View'),
                'title'    => Mage::helper('bannerslider')->__('Store View'),
                'required' => true,
                'values'   => $store,
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'  => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
        }

        $fieldsetConfig = $form->addFieldset('simplesliderconfig_form', array(
            'legend' => Mage::helper('bannerslider')->__('Slider Configuration')
        ));

        if ($this->getRequest()->getParam('type') != 'popup') {
            $fieldset->addField('position', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Position'),
                'name'   => 'position',
                'values' => Mage::getSingleton('bannerslider/position')->getBlockPosition(),
                'note' => 'Due to custom design reason. This function may not work, you can use snippet in <strong>Implement Code</strong> tab and copy to CMS Page/Static block, .phtml or layout.<br>
                    <a href="https://mageplaza.freshdesk.com/support/solutions/articles/6000117343" target="_blank">Insert Promo banner to checkout page</a>
                    '
            ));

        } else {
            $fieldset->addField('position', 'hidden', array(
                'name'  => 'position',
                'value' => 'pop-up',
            ));
            $fieldset->addField('pageview', 'multiselect', array(
                'label'  => Mage::helper('bannerslider')->__('Page View'),
                'name'  => 'pageview',
                'required' => true,
                'values' => Mage::getSingleton('bannerslider/pageview')->getPageView(),
            ));

        }
        /**
         * Config Slider
         */
        if ($this->getRequest()->getParam('type') == 'carousel') {


            $fieldset->addField('simple_slider_type', 'hidden', array(
                'name'  => 'simple_slider_type',
                'value' => Mageplaza_BannerSlider_Model_Simpleslider::TYPE_CAROUSEL
            ));
            $fieldsetConfig->addField('autoPlay', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Auto Play'),
                'name'   => 'autoPlay',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));


            $fieldsetConfig->addField('slideSpeed', 'text', array(
                'label'    => Mage::helper('bannerslider')->__('Slide Speed'),
                'name'     => 'slideSpeed',
                'required' => true,
                'value'    => 1000
            ));
            $fieldsetConfig->addField('navigation', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Navigation'),
                'name'   => 'navigation',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));

            $fieldsetConfig->addField('pagination', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Pagination'),
                'name'   => 'pagination',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));

            $fieldsetConfig->addField('stopOnHover', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Stop on hover'),
                'name'   => 'stopOnHover',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));

            $fieldsetConfig->addField('lazyLoad', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Lazy Loading'),
                'name'   => 'lazyLoad',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));

            $fieldsetConfig->addField('autoHeight', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Auto Height'),
                'name'   => 'autoHeight',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));


            $fieldsetConfig->addField('mouseDrag', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Mouse Drag'),
                'name'   => 'mouseDrag',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));


            $fieldsetConfig->addField('touchDrag', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Touch Drag'),
                'name'   => 'touchDrag',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));


            $fieldsetConfig->addField('effect', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Slide Effect'),
                'name'   => 'effect',
                'values' => Mage::getSingleton('bannerslider/effect')->getOptionHash(),
            ));

            $fieldsetConfig->addField('addClassActive', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Add Active Class'),
                'name'   => 'addClassActive',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1

            ));
        } elseif ($this->getRequest()->getParam('type') == 'popup') {
            $fieldset->addField('simple_slider_type', 'hidden', array(
                'name'  => 'simple_slider_type',
                'value' => Mageplaza_BannerSlider_Model_Simpleslider::TYPE_POPUP
            ));
            $fieldsetConfig->addField('autoPlay', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Auto Play'),
                'name'   => 'autoPlay',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));

            $fieldsetConfig->addField('slideSpeed', 'text', array(
                'label'    => Mage::helper('bannerslider')->__('Slide Speed'),
                'name'     => 'slideSpeed',
                'value'    => 1000,
                'required' => true,
            ));
            $fieldsetConfig->addField('autoSize', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Auto Size'),
                'name'   => 'autoSize',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));

            $fieldsetConfig->addField('autoResize', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Auto Resize'),
                'name'   => 'autoResize',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));
            $fieldsetConfig->addField('fitToView', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Fit to View'),
                'name'   => 'fitToView',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));
            $fieldsetConfig->addField('showNavigation', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Show Navigation Button'),
                'name'   => 'showNavigation',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1
            ));
            $fieldsetConfig->addField('openEffect', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Open Effect'),
                'name'   => 'openEffect',
                'values' => Mage::getSingleton('bannerslider/effect')->getPopupHash(),
            ));
            $fieldsetConfig->addField('closeEffect', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Close Effect'),
                'name'   => 'closeEffect',
                'values' => Mage::getSingleton('bannerslider/effect')->getPopupHash(),
            ));
            $fieldsetConfig->addField('prevEffect', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Preview Effect'),
                'name'   => 'prevEffect',
                'values' => Mage::getSingleton('bannerslider/effect')->getPopupHash(),
            ));
            $fieldsetConfig->addField('nextEffect', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Next Effect'),
                'name'   => 'nextEffect',
                'values' => Mage::getSingleton('bannerslider/effect')->getPopupHash(),
            ));

        } elseif ($this->getRequest()->getParam('type') == 'note') {

            $fieldset->addField('simple_slider_type', 'hidden', array(
                'name'  => 'simple_slider_type',
                'value' => Mageplaza_BannerSlider_Model_Simpleslider::TYPE_NOTE
            ));
        } elseif ($this->getRequest()->getParam('type') == 'flex') {

            $fieldset->addField('simple_slider_type', 'hidden', array(
                'name'  => 'simple_slider_type',
                'value' => Mageplaza_BannerSlider_Model_Simpleslider::TYPE_FLEX
            ));
            $fieldsetConfig->addField('reverse', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Reverse'),
                'name'   => 'reverse',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1,
                'note'   => $this->__('Boolean: Reverse the animation direction'),
            ));
            $fieldsetConfig->addField('animation', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Animation'),
                'name'   => 'animation',
                'values' => Mage::getSingleton('bannerslider/effect')->getFlexHash(),
            ));
            $fieldsetConfig->addField('animationLoop', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Animation Loop'),
                'name'   => 'animationLoop',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1,
                'note'   => $this->__('Should the animation loop? If false, directionNav will received "disable" classes at either end')
            ));
            $fieldsetConfig->addField('smoothHeight', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Smooth Height'),
                'name'   => 'smoothHeight',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1,
                'note'   => $this->__(' Boolean: Allow height of the slider to animate smoothly in horizontal mode'),
            ));
            $fieldsetConfig->addField('slideshow', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Slide Show'),
                'name'   => 'slideshow',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'note'   => $this->__('Animate slider automatically'),
            ));
            $fieldsetConfig->addField('slideshowSpeed', 'text', array(
                'label'    => Mage::helper('bannerslider')->__('Slide Show Speed'),
                'name'     => 'slideshowSpeed',
                'required' => true,
                'value'    => '2000',
            ));

            $fieldsetConfig->addField('randomize', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Randomize'),
                'name'   => 'randomize',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1,
                'note'   => $this->__('Boolean: Randomize slide order'),
            ));
            $fieldsetConfig->addField('useCSS', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Use Css'),
                'name'   => 'useCSS',
                'values' => Mage::getSingleton('bannerslider/yesno')->getOptionHash(),
                'value'  => 1,
                'note'   => $this->__('Boolean: Slider will use CSS3 transitions if available'),
            ));
            $fieldsetConfig->addField('direction', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Direction'),
                'name'   => 'direction',
                'values' => Mage::getSingleton('bannerslider/direction')->getOptionHash(),
                'note'   => $this->__('Select the sliding direction, "horizontal" or "vertical" '),
            ));

            $fieldsetConfig->addField('minItems', 'text', array(
                'label'    => Mage::helper('bannerslider')->__('Min Item'),
                'name'     => 'minItems',
                'value'    => 1,
                'required' => true,
                'note'     => $this->__('Default Value: 1. Minimum number of carousel items that should be visible. Items will resize fluidly when below this.'),
            ));
            $fieldsetConfig->addField('maxItems', 'text', array(
                'label'    => Mage::helper('bannerslider')->__('Max Item'),
                'name'     => 'maxItems',
                'value'    => 0,
                'required' => true,
                'note'     => $this->__('Default 0. Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.'),
            ));
        }

        /**
         * End Config Slider
         */
        if ($this->getRequest()->getParam('type') == 'carousel') {
            $fieldsetDevice = $form->addFieldset('simplesliderdevice_form', array(
                'legend' => Mage::helper('bannerslider')->__('Device Configuration')
            ));
            $fieldsetDevice->addField('device_1200', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Device\'s screen is greater than or equal to 1200px'),
                'name'   => 'device_1200',
                'values' => Mage::getSingleton('bannerslider/items')->getOptionHash(),
            ));

            $fieldsetDevice->addField('device_992', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Device\'s screen is greater than 992px or equal to 1199px'),
                'name'   => 'device_992',
                'values' => Mage::getSingleton('bannerslider/items')->getOptionHash(),
            ));

            $fieldsetDevice->addField('device_768', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Device\'s screen is greater than 768px or equal to 991px'),
                'name'   => 'device_768',
                'values' => Mage::getSingleton('bannerslider/items')->getOptionHash(),
            ));

            $fieldsetDevice->addField('device_481', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Device\'s screen is greater than 481px or equal to 767px'),
                'name'   => 'device_481',
                'values' => Mage::getSingleton('bannerslider/items')->getOptionHash(),
            ));

            $fieldsetDevice->addField('device_less_480', 'select', array(
                'label'  => Mage::helper('bannerslider')->__('Device\'s screen is less than 480px'),
                'name'   => 'device_less_480',
                'values' => Mage::getSingleton('bannerslider/items')->getOptionHash(),
            ));
        }
        if (!isset($fieldsetDevice))
            $fieldsetDevice = '';
        $form->addValues($slider->getData());

        Mage::dispatchEvent('bannerslider_adminhtml_simpleslider_form_slider', array(
            'form'           => $form,
            'fieldset'       => $fieldset,
            'fieldsetconfig' => $fieldsetConfig,
            'fieldsetdevice' => $fieldsetDevice
        ));

        $this->setForm($form);

        return parent::_prepareForm();
    }
}