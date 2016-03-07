<?php
/**
 * CorlleteLab
 *
 * Imagezoom extension
 *
 * @category	CorlleteLab
 * @package		CorlleteLab_Imagezoom
 * @copyright	Copyright (c) 2011 Corllete Ltd. (http://www.clabteam.com/)
 * @author		CorlleteLab Dev Team <office@clabteam.com>
 */

class CorlleteLab_Imagezoom_Model_Adminhtml_System_Config_Source_Zoomeffect
{
	public function toOptionArray()
	{
		return array(
			array('value' => "0", 	'label' => Mage::helper('imagezoom')->__('None')),
			array('value' => "1", 	'label' => Mage::helper('imagezoom')->__('Tint')),
			array('value' => "2", 	'label' => Mage::helper('imagezoom')->__('Soft Focus')),
		);
	}
}
?>