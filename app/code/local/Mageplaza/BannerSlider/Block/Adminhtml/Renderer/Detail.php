<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Renderer_Detail extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return sprintf('
			<a href="javascript:void(0);" onclick="%s">%s</a>',
            "window.open('".Mage::getSingleton('adminhtml/url')->getUrl('bannerslideradmin/adminhtml_banner/edit', array( 'sliderid' => $this->getRequest()->getParam('id'),'id' => $row->getId()))."','banner')",
            Mage::helper('bannerslider')->__('Edit')
        );
    }
}