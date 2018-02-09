<?php
class Mageplaza_BannerSlider_Model_Position extends Varien_Object
{

    /**
     * get model option as array
     *
     * @return array
     */
    public static function getPositionOptions()
    {
        return array(
            'cms_page_sliderTop'        => Mage::helper('bannerslider')->__('Homepage-Content-Top'),
            'right_sliderTop'           => Mage::helper('bannerslider')->__('Sidebar Right Top'),
            'right_sliderBottom'        => Mage::helper('bannerslider')->__('Sidebar Right Bottom'),
            'left_first_sliderTop'      => Mage::helper('bannerslider')->__('Sidebar Top Left'),
            'left_sliderBottom'         => Mage::helper('bannerslider')->__('Sidebar Bottom Left'),
            'content_sliderTop'         => Mage::helper('bannerslider')->__('Content Top'),
            'topMenu_sliderTop'         => Mage::helper('bannerslider')->__('Menu Top'),
            'topMenu_sliderBottom'      => Mage::helper('bannerslider')->__('Menu Bottom'),
            'before_body_end_sliderTop' => Mage::helper('bannerslider')->__('Page Bottom'),
            'checkout.cart_sliderTop' => Mage::helper('bannerslider')->__('Shopping Cart Page - Top'),
            'checkout.cart_sliderBottom' => Mage::helper('bannerslider')->__('Shopping Cart Page - Bottom'),
            'checkout.onepage_sliderTop' => Mage::helper('bannerslider')->__('Checkout Page - Top'),
            'checkout.onepage_sliderBottom' => Mage::helper('bannerslider')->__('Checkout Page - Bottom'),
        );
    }

    public static function getBlockPosition()
    {
        return array(
            array(
                'label' => Mage::helper('bannerslider')->__('------- Please choose position -------'),
                'value' => ''),
            array(
                'label' => Mage::helper('bannerslider')->__('Popular positions'),
                'value' => array(
                    array('value' => 'cms_page_sliderTop', 'label' => Mage::helper('bannerslider')->__('Homepage-Content-Top')),
                )),
            array(
                'label' => Mage::helper('bannerslider')->__('General (will be display on all pages)'),
                'value' => array(
                    array('value' => 'right_sliderTop', 'label' => Mage::helper('bannerslider')->__('Sidebar Right Top')),
                    array('value' => 'right_sliderBottom', 'label' => Mage::helper('bannerslider')->__('Sidebar Right Bottom')),
                    array('value' => 'left_first_sliderTop', 'label' => Mage::helper('bannerslider')->__('Sidebar Top Left')),
                    array('value' => 'left_sliderBottom', 'label' => Mage::helper('bannerslider')->__('Sidebar Bottom Left')),
                    array('value' => 'content_sliderTop', 'label' => Mage::helper('bannerslider')->__('Content Top')),
                    array('value' => 'topMenu_sliderTop', 'label' => Mage::helper('bannerslider')->__('Menu Top')),
                    array('value' => 'topMenu_sliderBottom', 'label' => Mage::helper('bannerslider')->__('Menu Bottom')),
                    array('value' => 'before_body_end_sliderTop', 'label' => Mage::helper('bannerslider')->__('Page Bottom')),
                    array('value' => 'checkout.cart_sliderTop', 'label' => Mage::helper('bannerslider')->__('Shopping Cart Page - Top')),
                    array('value' => 'checkout.cart_sliderBottom', 'label' => Mage::helper('bannerslider')->__('Shopping Cart Page - Bottom')),
                    array('value' => 'checkout.onepage_sliderTop', 'label' => Mage::helper('bannerslider')->__('Checkout Page - Top')),
                    array('value' => 'checkout.onepage_sliderBottom', 'label' => Mage::helper('bannerslider')->__('Checkout Page - Bottom')),


                )),
        );
    }

}