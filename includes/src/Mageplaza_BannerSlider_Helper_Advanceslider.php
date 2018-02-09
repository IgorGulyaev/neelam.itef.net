<?php

class Mageplaza_BannerSlider_Helper_Advanceslider extends Mage_Core_Helper_Abstract{


	public function getSelectslider(){
		$AdvancesliderModel = Mage::getModel('bannerslider/advanceslider')->getCollection();
		$slider = array(''=>'--Select Slider--');
		foreach($AdvancesliderModel as $advance){
			$slider[$advance->getId()] = $advance->getName();
		}
		return $slider;
	}

}