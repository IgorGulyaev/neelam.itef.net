<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Advanceslider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_advanceslider';
        $this->_blockGroup = 'bannerslider';
        $this->_headerText = Mage::helper('bannerslider')->__('Manage Advanced Slider');
        $this->_addButtonLabel = Mage::helper('bannerslider')->__('Add Slider');
        parent::__construct();
    }
}