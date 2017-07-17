<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Simpleslider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('simpleslider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bannerslider')->__('Slider Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('slider_section', array(
            'label'   => Mage::helper('bannerslider')->__('Slider Information'),
            'title'   => Mage::helper('bannerslider')->__('Slider Information'),
            'content' => $this->getLayout()->createBlock('bannerslider/adminhtml_simpleslider_edit_tab_slider')->toHtml(),
        ));
        $this->addTab('banner_section', array(
            'label'   => Mage::helper('bannerslider')->__('Select Banners'),
            'title'   => Mage::helper('bannerslider')->__('Select Banners'),
            'content' => $this->getLayout()->createBlock('bannerslider/adminhtml_simpleslider_edit_tab_banner')->toHtml(),
        ));
        $this->addTab('rule_section', array(
            'label'   => Mage::helper('bannerslider')->__('Conditions'),
            'title'   => Mage::helper('bannerslider')->__('Conditions'),
            'content' => $this->getLayout()->createBlock('bannerslider/adminhtml_simpleslider_edit_tab_rule')->toHtml(),
        ));
        $this->addTab('implement_section', array(
            'label'   => Mage::helper('bannerslider')->__('Implement Code (optional)'),
            'title'   => Mage::helper('bannerslider')->__('Implement Code (optional)'),
            'content' => $this->getLayout()->createBlock('bannerslider/adminhtml_simpleslider_edit_tab_implement')->toHtml(),
        ));

        Mage::dispatchEvent('bannerslider_adminhtml_banner_edit_tabs', array(
            'tabs' => $this
        ));

        $this->_updateActiveTab();

        return parent::_beforeToHtml();
    }

    protected function _updateActiveTab()
    {
        $tabId = $this->getRequest()->getParam('tab');
        if ($tabId) {
            $tabId = preg_replace("#{$this->getId()}_#", '', $tabId);
            if ($tabId) {
                $this->setActiveTab($tabId);
            }
        }
    }

}