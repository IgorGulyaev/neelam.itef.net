<?php
class Mageplaza_BannerSlider_Model_Banner extends Mage_Core_Model_Abstract
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;
    const TYPE_IMAGE = 1;
    const TYPE_FLASH = 2;
    public function _construct()
    {
        parent::_construct();
        $this->_init('bannerslider/banner');
    }
    static public function getTypeArray()
    {
        return array(

            self::TYPE_IMAGE  => Mage::helper('bannerslider')->__('Image'),
            self::TYPE_FLASH  => Mage::helper('bannerslider')->__('Flash'),
        );
    }
    static public function getTypeHash()
    {
        $options = array();
        foreach (self::getTypeArray() as $value => $label) {
            $options[] = array(
                'value' => $value,
                'label' => $label
            );
        }

        return $options;
    }

    public function toTypeArray()
    {
        return self::getTypeHash();
    }

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED  => Mage::helper('bannerslider')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('bannerslider')->__('Disabled')
        );
    }
    static public function getSizeFix()
    {
        return array(
            self::STATUS_DISABLED => Mage::helper('bannerslider')->__('Disabled'),
            self::STATUS_ENABLED  => Mage::helper('bannerslider')->__('Enabled'),
        );
    }
    static public function getOptionHash()
    {
        $options = array();
        foreach (self::getOptionArray() as $value => $label) {
            $options[] = array(
                'value' => $value,
                'label' => $label
            );
        }

        return $options;
    }

    public function toOptionArray()
    {
        return self::getOptionHash();
    }
}