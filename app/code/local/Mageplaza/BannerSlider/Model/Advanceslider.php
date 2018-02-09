<?php
class Mageplaza_BannerSlider_Model_Advanceslider extends Mage_Rule_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bannerslider/advanceslider');
    }


	protected function _beforeSave()
	{
		parent::_beforeSave();

		if ($this->hasStores()) {
			$groupIds = $this->getStores();
			if (is_array($groupIds) && !empty($groupIds)) {
				$this->setStoreId(implode(',', $groupIds));
			}
		}

		return $this;
	}
    public function getConditionsInstance()
    {
        return Mage::getModel('salesrule/rule_condition_combine');
    }

    public function getActionsInstance()
    {
        return Mage::getModel('salesrule/rule_condition_product_combine');
    }
}