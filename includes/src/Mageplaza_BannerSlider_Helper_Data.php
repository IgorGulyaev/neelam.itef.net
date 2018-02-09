<?php
class Mageplaza_BannerSlider_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'bannerslider/general/is_enabled';
    const XML_PATH_TRAFFIC_ENABLED = 'bannerslider/general/traffic_enabled';
    const XML_PATH_GENERAL_CONFIG = 'bannerslider/general/';
    const XML_PATH_EDITOR = 'bannerslider/general/editor';

    public function isEnabled($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_ENABLED, $store);
    }

    public function isTrafficEnabled($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_TRAFFIC_ENABLED, $store);
    }

    public function getEditor($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_EDITOR, $store);
    }

    public function getGeneralConfig($name, $store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_GENERAL_CONFIG . $name, $store);
    }


    public function getBannerImage($image)
    {
        return Mage::getBaseUrl('media') . 'mageplaza/bannerslider/banner/' . $image;
    }

    public static function getBannerFolder()
    {
        return Mage::getBaseDir('media') . DS . 'mageplaza' . DS . 'bannerslider' . DS . 'banner';
    }

    /**
     * delete image file
     *
     * @param type $image
     * @return type
     */
    public function deleteFile($fileName)
    {

        if (!$fileName) {
            return;
        }
        $fileDir = self::getBannerFolder() . DS . $fileName;
        if (!file_exists($fileDir)) {
            return;
        }

        try {

            unlink($fileDir);
        } catch (Exception $e) {

        }
    }

}