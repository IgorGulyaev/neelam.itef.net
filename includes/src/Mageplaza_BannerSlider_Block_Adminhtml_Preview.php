<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Preview extends Mage_Core_Block_Template
{
    public function getSliderData()
    {
        $id = $this->getRequest()->getParam('id');
        if (isset($id)) {
            $slider = Mage::getModel('bannerslider/simpleslider')->load($id);
            if ($slider->getId()) {
                return $slider;
            } else {
                return false;
            }
        }

        return false;
    }

    public function getSliderType()
    {
        $type = $this->getRequest()->getParam('type');

        return $type;
    }

    public function getBannerData()
    {
        $id            = $this->getRequest()->getParam('id');
        $bannerDetails = Mage::getModel('bannerslider/bannerdetail')->getCollection()
            ->addFieldToFilter('simple_slider_id', $id);
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
            ->where('dt.simple_slider_id=' . $id);
        $banners->setOrder('dt.order', "ASC");

        return $banners;
    }

    public function getBannerImage($imageName)
    {
        return Mage::helper('bannerslider')->getBannerImage($imageName);

    }

    public function getAdvanceData()
    {
        $id            = $this->getRequest()->getParam('id');
        $advanceSlider = Mage::getModel('bannerslider/advanceslider')->load($id);
        if ($advanceSlider->getId()) {
            return $advanceSlider;
        }

        return false;
    }
}