<?php

class Mageplaza_BannerSlider_Model_Effect extends Varien_Object
{

    /**
     * get model option as array
     *
     * @return array
     */

    const POPUP_FADE = '"fade"';
    const POPUP_ELASTIC = '"elastic"';
    const POPUP_NONE = '"none"';
    const FLEX_FADE='"fade"';
    const FLEX_SLIDE='"slide"';
    static public function getFlexArray(){
        return array(
            self::FLEX_FADE => Mage::helper('bannerslider')->__('Fade'),
            self::FLEX_SLIDE => Mage::helper('bannerslider')->__('Slide'),
        );
    }
    static public function getFlexHash()
    {
        $options = array();
        foreach (self::getFlexArray() as $value => $label) {
            $options[] = array(
                'value' => $value,
                'label' => $label
            );
        }

        return $options;
    }
    static public function getPopupArray(){
        return array(
            self::POPUP_FADE => Mage::helper('bannerslider')->__('Fade'),
            self::POPUP_ELASTIC => Mage::helper('bannerslider')->__('Elastic'),
            self::POPUP_NONE => Mage::helper('bannerslider')->__('None'),
        );
    }
    static public function getPopupHash()
    {
        $options = array();
        foreach (self::getPopupArray() as $value => $label) {
            $options[] = array(
                'value' => $value,
                'label' => $label
            );
        }

        return $options;
    }
    static public function getOptionArray()
    {
        return array(
            'slide'     => Mage::helper('bannerslider')->__('Slide'),
            'fade'      => Mage::helper('bannerslider')->__('Fade'),
            'backSlide' => Mage::helper('bannerslider')->__('backSlide'),
            'goDown'    => Mage::helper('bannerslider')->__('goDown'),
            'fadeUp'    => Mage::helper('bannerslider')->__('fadeUp'),
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
                'value' => $value,
                'label' => $label
            );
        }

        return $options;
    }
}