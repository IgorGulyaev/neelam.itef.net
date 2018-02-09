<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Renderer_Order extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function _getInputValueElement(Varien_Object $row)
    {
        $sliderId     = $this->getRequest()->getParam('id');
        $bannerDetail = Mage::getModel('bannerslider/bannerdetail')->getCollection()
            ->addFieldToFilter('banner_id', $row->getId())
            ->addFieldToFilter('simple_slider_id', $sliderId)
            ->getFirstItem();

        return '<input type="text" class="input-text '
        . $this->getColumn()->getValidateClass()
        . '" name="' . $this->getColumn()->getId() . '[' . $row->getId() . ']'
        . '" value="' . $bannerDetail->getOrder() . '"/>';
    }
}