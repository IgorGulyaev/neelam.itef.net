<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Banner_Renderer_Link extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        if($this->getRequest()->getActionName()=='export')
            return $value;
        return '<a href="'.$value.'">'.$value.'</a>';
    }
}