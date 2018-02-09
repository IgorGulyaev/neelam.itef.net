<?php
class Mageplaza_BannerSlider_Model_Mysql4_Advanceslider extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('bannerslider/advanceslider', 'advance_slider_id');
    }
}