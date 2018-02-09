<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Banner_Edit_Tab_Statistic extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $banner = Mage::registry('current_banner');
        $click=Mage::getModel('bannerslider/traffic')->getCollection()->addFieldToFilter('banner_id',$banner->getId());
        $click->getSelect()->columns(array(
            'totalrawclick' => 'COUNT(traffic_id)',
            'totaluniqueclick' => 'COUNT(DISTINCT(ip_address))',
        ))->where('type_id = 1');
        $data=$click->getFirstItem();
        $impression=Mage::getModel('bannerslider/traffic')->getCollection()->addFieldToFilter('banner_id',$banner->getId())->addFieldToFilter('type_id',2);
        $fieldset = $form->addFieldset('banner_form', array(
            'legend' => Mage::helper('bannerslider')->__('Static Information')
        ));
        $fieldset->addField('raw_clicks', 'note', array(
            'label' => Mage::helper('bannerslider')->__('Clicks (unique/ raw)'),
            'text'  => $data->getTotaluniqueclick() . ' / ' . $data->getTotalrawclick(),
        ));
//        $fieldset->addField('views', 'note', array(
//            'label' => Mage::helper('bannerslider')->__('Impressions (raw)'),
//            'text'  =>  $impression->getSize(),
//        ));
        $this->setForm($form);
        return parent::_prepareForm();
    }
}