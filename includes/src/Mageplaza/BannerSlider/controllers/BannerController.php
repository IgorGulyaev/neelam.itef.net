<?php
class Mageplaza_BannerSlider_BannerController extends Mage_Core_Controller_Front_Action
{
    public function trafficAction()
    {
        $isTrafficEnabled = Mage::helper('bannerslider')->isTrafficEnabled();
        $helper      = Mage::helper('core/http');
        $httpReferer = $helper->getHttpReferer(true);
        $ip          = $helper->getRemoteAddr(false);
        $type        = $this->getRequest()->getParam('type', null);
        $bannerId = $this->getRequest()->getParam('banner_id', null);
        $banner = Mage::getModel('bannerslider/banner')->load($bannerId);
        if ($isTrafficEnabled  && $bannerId !== null) {

            if (!($banner->getId()))
                return $this;
            if ($type == 'impression') {
                $type=2;
                $impression = $banner->getImpression() + 1;
                $banner->setImpression($impression);
                $banner->save();
            } elseif ($type == 'click') {
                $type=1;
                $isUnique = false;
                if ( $banner->getId()) {
                    $traffic = Mage::getModel('bannerslider/traffic')->getCollection()
                        ->addFieldToFilter('banner_id', $bannerId)
                        ->addFieldToFilter('ip_address', $ip)
                        ->addFieldToFilter('type_id',1)->getFirstItem();
                    if (!$traffic->getId()) {
                        $isUnique = true;
                    }
                    $bannerRawClicks    = $banner->getRawClicks() + 1;
                    $bannerUniqueClicks = $banner->getUniqueClicks();
                    if ($isUnique) {
                        $bannerUniqueClicks += 1;
                    }
                    $banner->setRawClicks($bannerRawClicks);
                    $banner->setUniqueClicks($bannerUniqueClicks);
                    $banner->save();
                }
            }
            $data     = array('banner_id' => $bannerId, 'ip_address' => $ip,'visit_at' => now(), 'http_referer' => $httpReferer,'type_id' => $type);
            $traffic  = Mage::getModel('bannerslider/traffic')->setData($data);
            $traffic->save();
        }
        return;
    }
}