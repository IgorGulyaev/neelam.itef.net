<?php

class Mageplaza_BannerSlider_Block_Simpleslider extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getSimpleData()
    {
        if (!$this->hasData('simple_data')) {
            $simpleSliderId = $this->getSimpleSliderId();
            if ($simpleSliderId) {
                $sliderData = Mage::getModel('bannerslider/simpleslider')->load($simpleSliderId);
            } else {
                $sliderData = $this->getSliderData();
            }
            $bannerDetails = Mage::getModel('bannerslider/bannerdetail')->getCollection()
                ->addFieldToFilter('simple_slider_id', $sliderData->getId());
            $bannerIdArr   = array();
            foreach ($bannerDetails as $bannerDetail) {
                $bannerIdArr[] = $bannerDetail->getBannerId();
            }
            $banners = Mage::getModel('bannerslider/banner')->getCollection()
                ->addFieldToFilter('status', Mageplaza_BannerSlider_Model_Banner::STATUS_ENABLED)
                ->addFieldToFilter('main_table.banner_id', array('in' => $bannerIdArr));
            $banners->getSelect()
                ->joinLeft(
                    array('dt' => $banners->getTable('bannerslider/bannerdetail')),
                    "main_table.banner_id = dt.banner_id",
                    array('dt.order')
                )
                ->where('dt.simple_slider_id=' . $sliderData->getId());
            $banners->setOrder('dt.order', "ASC");
            $result            = array();
            $result['simple_slider']   = $sliderData;
            $result['banners'] = array();
            foreach ($banners as $banner) {
                $result['banners'][] = $banner->getData();
            }
            $this->setData('simple_data', $result);
        }
        return $this->getData('simple_data');
    }

    public function getSliderTemplate($sliderType, $data)
    {
        switch ($sliderType) {
            case Mageplaza_BannerSlider_Model_Simpleslider::TYPE_CAROUSEL:
                $html = $this->getLayout()->createBlock('bannerslider/simpleslider')->setSimpleSliderData($data)->setTemplate('mageplaza/bannerslider/simpleslider/carousel.phtml')->toHtml();
                break;
            case Mageplaza_BannerSlider_Model_Simpleslider::TYPE_POPUP:
                $html = $this->getLayout()->createBlock('bannerslider/simpleslider')->setSimpleSliderData($data)->setTemplate('mageplaza/bannerslider/simpleslider/popup.phtml')->toHtml();
                break;
            case Mageplaza_BannerSlider_Model_Simpleslider::TYPE_NOTE:
                $html = $this->getLayout()->createBlock('bannerslider/simpleslider')->setSimpleSliderData($data)->setTemplate('mageplaza/bannerslider/simpleslider/note.phtml')->toHtml();
                break;
            case Mageplaza_BannerSlider_Model_Simpleslider::TYPE_FLEX:
                $html = $this->getLayout()->createBlock('bannerslider/simpleslider')->setSimpleSliderData($data)->setTemplate('mageplaza/bannerslider/simpleslider/flex.phtml')->toHtml();
                break;
            default :
                $html = '';
        }

        return $html;
    }

    public function getBannerImage($imageName)
    {
        return Mage::helper('bannerslider')->getBannerImage($imageName);
    }
}