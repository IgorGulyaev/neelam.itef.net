<?php
class Mageplaza_BannerSlider_Model_Mysql4_Bannerslider extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('bannerslider/bannerslider', 'bannerslider_id');
    }
}