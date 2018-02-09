<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Simpleslider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller     = 'adminhtml_simpleslider';
        $this->_blockGroup     = 'bannerslider';
        $this->_addButtonLabel = Mage::helper('bannerslider')->__('Add Slider');
        if (Mage::registry('useCarouselFilter') === true) {
            $this->_headerText = Mage::helper('bannerslider')->__('Carousel Manager');
        } elseif (Mage::registry('usePopupFilter') === true) {
            $this->_headerText = Mage::helper('bannerslider')->__('Popup Manager');
        } elseif (Mage::registry('useNoteFilter') === true) {
            $this->_headerText = Mage::helper('bannerslider')->__('Note Manager');
        } elseif (Mage::registry('useFlexFilter') === true) {
            $this->_headerText = Mage::helper('bannerslider')->__('Flex Manager');
        }
        parent::__construct();
    }

    public function getCreateUrl()
    {
        if (Mage::registry('useCarouselFilter') === true) {
            return $this->getUrl('*/*/new', array('type' => 'carousel'));
        } elseif (Mage::registry('usePopupFilter') === true) {
            return $this->getUrl('*/*/new', array('type' => 'popup'));
        } elseif (Mage::registry('useNoteFilter') === true) {
            return $this->getUrl('*/*/new', array('type' => 'note'));
        } elseif (Mage::registry('useFlexFilter') === true) {
            return $this->getUrl('*/*/new', array('type' => 'flex'));
        }

    }
}

