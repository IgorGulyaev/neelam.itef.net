<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Banner_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $type = $row->getData($this->getColumn()->getIndex());
        if (($type == 1) && $row->getSourceFile())
            return '<img width="150" src="' . Mage::getBaseUrl('media') . 'mageplaza/bannerslider/banner/' . $row->getSourceFile() . '" />';
        if ($type == 2 && $row->getSourceFile()) {
            $banner = '<embed src="' . Mage::getBaseUrl('media') . 'mageplaza/bannerslider/banner/' . $row->getSourceFile() . '" title="' . $row->getTitle() . '" width="150" " height="100"" type="application/x-shockwave-flash" play="true" loop="true" wmode="transparent" allowscriptaccess="always" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" />';

            return $banner;
        }
        if ($type == 3)
            return 'Text';
    }
}