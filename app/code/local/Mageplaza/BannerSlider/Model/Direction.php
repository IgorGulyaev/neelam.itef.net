<?php
class Mageplaza_BannerSlider_Model_Direction extends Varien_Object
{
    const HORIZONTAL = '"horizontal"';
    const VERTICAL = '"vertical"';
    static public function getOptionArray(){
        return array(
            self::HORIZONTAL => Mage::helper('bannerslider')->__('Horizontal'),
            self::VERTICAL => Mage::helper('bannerslider')->__('Vertical'),

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
}