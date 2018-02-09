<?php

class Mageplaza_BannerSlider_Model_Block_Observer
{
    protected static $flagPopup = true;

    public function afterOutputHtml($observer)
    {
        if(!Mage::helper('bannerslider')->isEnabled()){
            return $this;
        }
        $block      = $observer->getEvent()->getBlock();
        $transport  = $observer->getEvent()->getTransport();
        $blockAlias = $block->getBlockAlias();
        $storeId    = Mage::app()->getStore()->getStoreId();
        if (empty($transport)) {
            return $this;
        }
        if (!Mage::helper('bannerslider')->isEnabled()) {
            return '';
        }

        if ($blockAlias == 'cms_page' || $blockAlias == 'product_list' || $blockAlias == 'product.info' || $blockAlias == 'footer_before') {
            //            Mageplaza_BannerSlider_Model_Block_Observer::$flagPopup = false;
            $collection = Mage::getModel('bannerslider/simpleslider')->getCollection()
                ->addFieldToFilter('status', 1)
                ->addFieldToFilter('simple_slider_type', Mageplaza_BannerSlider_Model_Simpleslider::TYPE_POPUP)
                ->addFieldToFilter('store_id', array('finset' => $storeId));
            if ($collection->getSize()) {
                $this->_showSliderPopup($block, $transport, $collection, true, $blockAlias);
            }
        }
        $collection = Mage::getModel('bannerslider/simpleslider')->getCollection()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('position', $blockAlias . '_sliderTop')
            ->addFieldToFilter('store_id', array('finset' => $storeId));
        if ($collection->getSize()) {
            $this->_showSlider($block, $transport, $collection, true);
        }
        $collection = Mage::getModel('bannerslider/simpleslider')->getCollection()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('position', $blockAlias . '_sliderBottom')
            ->addFieldToFilter('store_id', array('finset' => $storeId));
        if ($collection->getSize()) {
            $this->_showSlider($block, $transport, $collection, false);
        }

        if (version_compare(Mage::getVersion(), '1.9.0.0', '<')) {
            if ($blockAlias == 'left') {
                $collection = Mage::getModel('bannerslider/simpleslider')->getCollection()
                    ->addFieldToFilter('status', 1)
                    ->addFieldToFilter('position', 'left_first_sliderTop')
                    ->addFieldToFilter('store_id', array('finset' => $storeId));
                $this->_showSlider($block, $transport, $collection, true);
            }
        }

        /** Advanced sliders */
        $collection = Mage::getModel('bannerslider/advanceslider')->getCollection()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('position', $blockAlias . '_sliderTop')
            ->addFieldToFilter('store_id', array('finset' => $storeId));
        if ($collection->getSize()) {
            $this->_showAdvanceSlider($block, $transport, $collection, true);
        }
        $collection = Mage::getModel('bannerslider/advanceslider')->getCollection()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('position', $blockAlias . '_sliderBottom')
            ->addFieldToFilter('store_id', array('finset' => $storeId));
        if ($collection->getSize()) {
            $this->_showAdvanceSlider($block, $transport, $collection, false);
        }
        if (version_compare(Mage::getVersion(), '1.9.0.0', '<')) {
            if ($blockAlias == 'left') {
                $collection = Mage::getModel('bannerslider/advanceslider')->getCollection()
                    ->addFieldToFilter('status', 1)
                    ->addFieldToFilter('position', 'left_first_sliderTop')
                    ->addFieldToFilter('store_id', array('finset' => $storeId));
                if ($collection->getSize()) {
                    $this->_showAdvanceSlider($block, $transport, $collection, false);
                }
            }
        }

        /** End Advanced Slider */

        return $this;
    }

    protected function _showSlider($block, $transport, $collection, $position)
    {
        $checkout = Mage::getSingleton('checkout/session')->getQuote();
        if ($checkout->isVirtual() && $checkout->getAddressType() == 'shipping') {
            $address = $checkout->getBillingAddress();
        } else {
            $address = $checkout->getShippingAddress();
        }
        $html = $transport->getHtml();
        foreach ($collection as $item) {
            if ($item->validate($address)) {
                $append_html = $block->getLayout()->createBlock('bannerslider/simpleslider')
                    ->setTemplate('mageplaza/bannerslider/simpleslider.phtml')->setSliderData($item)
                    ->renderView();
                if (isset($append_html)) {
                    if ($position) {
                        $transport->setHtml($append_html . $html);
                        $html = $append_html . $html;
                    } else {
                        $transport->setHtml($html . $append_html);
                        $html = $html . $append_html;
                    }
                }
            }
        }
    }

    protected function _showSliderPopup($block, $transport, $collection, $position, $blockAlias)
    {
        $checkout = Mage::getSingleton('checkout/session')->getQuote();
        if ($checkout->isVirtual() && $checkout->getAddressType() == 'shipping') {
            $address = $checkout->getBillingAddress();
        } else {
            $address = $checkout->getShippingAddress();
        }
        $html = $transport->getHtml();
        foreach ($collection as $item) {
            if ($item->validate($address)) {
                $extend   = Mage::helper('core')->jsonDecode($item->getExtend());
                $arrPageView = explode("%",$extend['pageview']);
                if (in_array($blockAlias,$arrPageView)) {
                    $append_html = $block->getLayout()->createBlock('bannerslider/simpleslider')
                        ->setTemplate('mageplaza/bannerslider/simpleslider.phtml')->setSliderData($item)
                        ->renderView();
                    if (isset($append_html)) {
                        if ($position) {
                            $transport->setHtml($append_html . $html);
                            $html = $append_html . $html;
                        } else {
                            $transport->setHtml($html . $append_html);
                            $html = $html . $append_html;
                        }
                    }
                }
            }
        }
    }

    protected function _showAdvanceSlider($block, $transport, $collection, $position)
    {
        $html     = $transport->getHtml();
        $checkout = Mage::getSingleton('checkout/session')->getQuote();
        if ($checkout->isVirtual() && $checkout->getAddressType() == 'shipping') {
            $address = $checkout->getBillingAddress();
        } else {
            $address = $checkout->getShippingAddress();
        }
        foreach ($collection as $item) {
            if ($item->validate($address)) {
                $append_html = $block->getLayout()->createBlock('bannerslider/advanceslider')
                    ->setTemplate('mageplaza/bannerslider/advanceslider.phtml')->setSliderData($item)
                    ->renderView();
                if (isset($append_html)) {
                    if ($position) {
                        $transport->setHtml($append_html . $html);
                        $html = $append_html . $html;
                    } else {
                        $transport->setHtml($html . $append_html);
                        $html = $html . $append_html;
                    }
                }
            }
        }
    }
}
