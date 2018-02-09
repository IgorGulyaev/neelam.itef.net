<?php
class Mageplaza_BannerSlider_Model_Mysql4_Banner extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('bannerslider/banner', 'banner_id');
    }
}