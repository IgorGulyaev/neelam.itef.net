<?php
class Mageplaza_BannerSlider_Block_Advanceslider extends Mage_Core_Block_Template
{
    /**
     * prepare block's layout
     *
     * @return Mageplaza_BannerSlider_Block_Advanceslider
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getBlockData()
    {
        if (!$this->hasData('block_data')) {
            $advanceSliderId = $this->getAdvanceSliderId();
            if ($advanceSliderId) {
                $sliderData = Mage::getModel('bannerslider/advanceslider')->load($advanceSliderId);
            } else {
                $sliderData = $this->getSliderData();
            }
            $result                  = array();
            $result['advanceslider'] = $sliderData;
            $result['banners']       = array();
            $this->setData('block_data', $result);
        }

        return $this->getData('block_data');
    }

    public function getBannerImage($imageName)
    {
        return Mage::helper('bannerslider')->getBannerImage($imageName);
    }

    public function getHtmlText($html)
    {
        $isSecure    = Mage::app()->getStore()->isCurrentlySecure();
        $baseSkinUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN, $isSecure) . 'frontend/base/default';

        return str_replace('{base_skin_url}', $baseSkinUrl, $html);
    }

}