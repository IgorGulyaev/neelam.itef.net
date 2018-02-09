<?php
class Mageplaza_BannerSlider_Model_Mysql4_Bannerdetail extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('bannerslider/bannerdetail', 'banner_detail_id');
    }
}