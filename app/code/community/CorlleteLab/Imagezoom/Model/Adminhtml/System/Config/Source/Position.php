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

class CorlleteLab_Imagezoom_Model_Adminhtml_System_Config_Source_Position
{
	public function toOptionArray()
	{
		return array(
			array('value' => "'left'", 		'label' => Mage::helper('imagezoom')->__('Left')),
			array('value' => "'right'", 	'label' => Mage::helper('imagezoom')->__('Right')),
			array('value' => "'top'", 		'label' => Mage::helper('imagezoom')->__('Top')),
			array('value' => "'bottom'", 	'label' => Mage::helper('imagezoom')->__('Bottom')),
			array('value' => "'inside'", 	'label' => Mage::helper('imagezoom')->__('Inside (Inner Zoom)'))
		);
	}
}
?>