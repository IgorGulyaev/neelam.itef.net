<?php
class Mageplaza_BannerSlider_Model_Mysql4_Simpleslider extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('bannerslider/simpleslider', 'simple_slider_id');
    }
}