<?php
/**
 * CorlleteLab
 *
 * Imagezoom extension
 *
 * @category   CorlleteLab
 * @package	CorlleteLab_Imagezoom
 * @copyright  Copyright (c) 2011 Corllete Ltd. (http://www.clabteam.com/)
 * @author	 CorlleteLab Dev Team <office@clabteam.com>
 */

class CorlleteLab_Imagezoom_Block_Catalog_Product_View extends Mage_Catalog_Block_Product_View
{
	/**
	 * Add meta information from product to head block
	 *
	 * @return Mage_Catalog_Block_Product_View
	 */
	protected function _prepareLayout()
	{
		$this->getLayout()->createBlock('catalog/breadcrumbs');
		$headBlock = $this->getLayout()->getBlock('head');
		
		if ($headBlock) {
			/* ImageZoom Options */
			if (Mage::getStoreConfig('imagezoomconfig/moduleoptions/moduleenable')) {
				$jq_noConflict = '
					<script type="text/javascript">
						//<![CDATA[
							var jq = jQuery.noConflict();
						//]]>
					</script>
				';
				
				if (Mage::getStoreConfig('imagezoomconfig/moduleoptions/jquery')) {
					if (Mage::getStoreConfig('imagezoomconfig/moduleoptions/jqueryexternal')) {
						$headBlock -> addExternalItem('external_js','https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js');
					} else {
						$headBlock -> addExternalItem('external_js',Mage::getBaseUrl().'js/corlletelab/imagezoom/jquery-1.6.2.min.js');
					}
					
					$headBlock -> addExternalItem('source',$jq_noConflict);
				}
				
				$headBlock -> addExternalItem('external_js', Mage::getBaseUrl().'js/corlletelab/imagezoom/cloud-zoom.1.0.2.js');
				$headBlock -> addItem('skin_css','css/corlletelab/imagezoom.css');
				
				$css = '
					<style type="text/css">
						.cloud-zoom-lens {
							border: '.Mage::getStoreConfig('imagezoomconfig/imagezoom_style_css/lens_border').'px solid #'.Mage::getStoreConfig('imagezoomconfig/imagezoom_style_css/lens_border_color').';
							margin:-'.Mage::getStoreConfig('imagezoomconfig/imagezoom_style_css/lens_border').'px;	/* Set this to minus the border thickness. */
							background-color: #'.Mage::getStoreConfig('imagezoomconfig/imagezoom_style_css/lens_background_color').';	
						}
						.cloud-zoom-big {
							border: '.Mage::getStoreConfig('imagezoomconfig/imagezoom_style_css/zoom_window_border').'px solid #'.Mage::getStoreConfig('imagezoomconfig/imagezoom_style_css/zoom_window_border_color').';
						}
					</style>
				';
				
				$headBlock -> addExternalItem('source',$css);
			}
			
		}

		return parent::_prepareLayout();
	}
}
