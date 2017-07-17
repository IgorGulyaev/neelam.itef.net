<?php
class Mageplaza_BannerSlider_Block_Adminhtml_AdvanceSlider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('advanceslider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bannerslider')->__('Slider Information'));
    }

    /**
     * prepare before render block to html
     *
     * @return Mageplaza_BannerSlider_Block_Adminhtml_Bannerslider_Edit_Tabs
     */
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'   => Mage::helper('bannerslider')->__('General'),
            'title'   => Mage::helper('bannerslider')->__('General'),
            'content' => $this->getLayout()
                ->createBlock('bannerslider/adminhtml_advanceslider_edit_tab_form')
                ->toHtml(),
        ));
        $this->addTab('content_section', array(
            'label'   => Mage::helper('bannerslider')->__('Content'),
            'title'   => Mage::helper('bannerslider')->__('Content'),
            'content' => $this->getLayout()
                ->createBlock('bannerslider/adminhtml_advanceslider_edit_tab_content')
                ->toHtml(),
        ));
        $this->addTab('rule_section', array(
            'label'   => Mage::helper('bannerslider')->__('Conditions'),
            'title'   => Mage::helper('bannerslider')->__('Conditions'),
            'content' => $this->getLayout()->createBlock('bannerslider/adminhtml_advanceslider_edit_tab_rule')->toHtml(),
        ));
        $this->addTab('implement_section', array(
            'label'   => Mage::helper('bannerslider')->__('Implement Code (optional)'),
            'title'   => Mage::helper('bannerslider')->__('Implement Code (optional)'),
            'content' => $this->getLayout()->createBlock('bannerslider/adminhtml_advanceslider_edit_tab_implement')->toHtml(),
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