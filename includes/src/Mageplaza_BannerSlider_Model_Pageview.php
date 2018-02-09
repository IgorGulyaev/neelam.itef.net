<?php
class Mageplaza_BannerSlider_Model_Pageview extends Varien_Object
{
    public static function getPageView()
    {
        return array(
            array('value' => 'cms_page', 'label' => Mage::helper('bannerslider')->__('Homepage')),
            array('value' => 'product.info', 'label' => Mage::helper('bannerslider')->__('Product view')),
            array('value' => 'product_list', 'label' => Mage::helper('bannerslider')->__('Product Listing')),
            array('value' => 'footer_before', 'label' => Mage::helper('bannerslider')->__('All pages')),
        );
    }
}