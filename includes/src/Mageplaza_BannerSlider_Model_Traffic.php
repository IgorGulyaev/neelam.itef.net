<?php
class Mageplaza_BannerSlider_Model_Traffic extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bannerslider/traffic');
    }
}