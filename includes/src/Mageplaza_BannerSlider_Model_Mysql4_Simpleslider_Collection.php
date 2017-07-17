<?php
class Mageplaza_BannerSlider_Model_Mysql4_Simpleslider_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bannerslider/simpleslider');
    }
}