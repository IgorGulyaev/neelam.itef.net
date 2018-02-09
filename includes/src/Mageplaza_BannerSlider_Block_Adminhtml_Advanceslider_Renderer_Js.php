<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Advanceslider_Renderer_Js extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
	/* Render Grid Column*/
	public function render(Varien_Object $row){

			if($row->getJsText()){
				echo $row->getJsText();
//            return sprintf('
//                <a href="%s">%s</a>',
//				Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS).'/simpleaffiliate/'.$row->getImage(),
//				'<img alt="" src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS).'simpleaffiliate/'.$row->getImage().'" width="150" />'
//			);
		}
    }
}