<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Banner_View  extends Mage_Core_Block_Template
{
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();

        $banner = Mage::registry('banner');

        if(!$banner)
            $banner = $this->getBanner();
        if(!$banner)
            $bannerType = $this->getBannerType();
        else
            $bannerType = $banner->getTypeId();
        if((int)$bannerType == Mageplaza_BannerSlider_Model_Banner::TYPE_IMAGE){
            $this->setTemplate('mageplaza/bannerslider/banner/image.phtml');
        }
        if((int)$bannerType == Mageplaza_BannerSlider_Model_Banner::TYPE_FLASH){
            $this->setTemplate('mageplaza/bannerslider/banner/flash.phtml');
}
        return $this;
    }
}