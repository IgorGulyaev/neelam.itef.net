<?php
class Mageplaza_BannerSlider_Model_Status extends Varien_Object
{
    const STATUS_ENABLED    = 1;
    const STATUS_DISABLED    = 2;
    
    /**
     * get model option as array
     *
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('bannerslider')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('bannerslider')->__('Disabled')
        );
    }
    
    /**
     * get model option hash as array
     *
     * @return array
     */
    static public function getOptionHash()
    {
        $options = array();
        foreach (self::getOptionArray() as $value => $label) {
            $options[] = array(
                'value'    => $value,
                'label'    => $label
            );
        }
        return $options;
    }

    public function toOptionArray()
    {
        return self::getOptionHash();
    }
    
}