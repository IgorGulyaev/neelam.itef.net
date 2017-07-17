<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Banner_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('banner_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bannerslider')->__('Banner Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'   => Mage::helper('bannerslider')->__('Banner Information'),
            'title'   => Mage::helper('bannerslider')->__('Banner Information'),
            'content' => $this->getLayout()->createBlock('bannerslider/adminhtml_banner_edit_tab_form')->toHtml(),
        ));
        if ($this->getRequest()->getParam('id') && (Mage::helper('bannerslider')->isTrafficEnabled())) {
            $this->addTab('statistic_section', array(
                'label'   => Mage::helper('bannerslider')->__('Statistic Information'),
                'title'   => Mage::helper('bannerslider')->__('Statistic Information'),
                'content' => $this->getLayout()->createBlock('bannerslider/adminhtml_banner_edit_tab_statistic')->toHtml(),
            ));
        } else {

        }

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