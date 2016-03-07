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

class CorlleteLab_Imagezoom_Model_Adminhtml_System_Color extends Mage_Core_Model_Config_Data
{
    public function save()
    {
		$value = $this->getValue(); //get the value from our config
		
        if((strlen($value) >0 && strlen($value) < 3) || (strlen($value) > 3 && strlen($value) < 6) || strlen($value) > 6)
        {
            Mage::throwException("Please enter valid color value (3 or 6 characters). Colours should be specified in hex format");
        }
       
		return parent::save();
    }
}
?>