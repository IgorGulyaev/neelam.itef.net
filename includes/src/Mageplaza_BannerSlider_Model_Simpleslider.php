<?php
class Mageplaza_BannerSlider_Model_Simpleslider extends Mage_Rule_Model_Abstract
{
    const TYPE_CAROUSEL = 1;
    const TYPE_POPUP = 2;
    const TYPE_NOTE = 3;
    const TYPE_FLEX = 4;
    const YES = 1;
    const NO = 2;

    public function _construct()
    {
        parent::_construct();
        $this->_init('bannerslider/simpleslider');
    }
    public function getOptionArray()
    {
        return array(
            self::YES  => Mage::helper('bannerslider')->__('Yes'),
            self::NO => Mage::helper('bannerslider')->__('No')
        );
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