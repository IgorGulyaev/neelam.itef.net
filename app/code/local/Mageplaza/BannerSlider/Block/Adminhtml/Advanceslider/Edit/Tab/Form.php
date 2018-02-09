<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Advanceslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare tab form's information
     *
     * @return Mageplaza_BannerSlider_Block_Adminhtml_Bannerslider_Edit_Tab_Form
     */
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        if (Mage::getSingleton('adminhtml/session')->getAdvancesliderData()) {
            $data = Mage::getSingleton('adminhtml/session')->getAdvanceSliderData();
            Mage::getSingleton('adminhtml/session')->setAdvanceSliderData(null);
        } elseif (Mage::registry('advanceslider_data')) {
            $data = Mage::registry('advanceslider_data');
        }
        $fieldset = $form->addFieldset('advanceslider_form', array(
            'legend' => Mage::helper('bannerslider')->__('Slider information')
        ));


        $fieldset->addField('name', 'text', array(
            'label'    => Mage::helper('bannerslider')->__('Name'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => 'name',
        ));


        $fieldset->addField('select_slider', 'select', array(
            'label'    => Mage::helper('bannerslider')->__('Load from samples'),
            'name'     => 'select_slider',
            'onchange' => 'loadData(\'' . $this->getUrl('bannerslideradmin/adminhtml_advanceslider/loadData') . '\', this.value)',
            'values'   => Mage::helper('bannerslider/Advanceslider')->getSelectslider(),
            'value'    => isset($data['select_slider']) ? $data['select_slider'] : '',
        ));




        $fieldset->addField('status', 'select', array(
            'label'  => Mage::helper('bannerslider')->__('Status'),
            'name'   => 'status',
            'values' => Mage::getSingleton('bannerslider/status')->getOptionHash(),

        ));


        $fieldset->addField('position', 'select', array(
            'label'  => Mage::helper('bannerslider')->__('Position'),
            'name'   => 'position',
            'values' => Mage::getSingleton('bannerslider/position')->getBlockPosition(),
        ));

        $store = Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false);
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name'     => 'stores[]',
                'label'    => Mage::helper('bannerslider')->__('Store View'),
                'title'    => Mage::helper('bannerslider')->__('Store View'),
                'required' => true,
                'values'   => $store,
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'  => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
        }
        $fieldset->addField('js_text', 'editor', array(
            'name'     => 'js_text',
            'label'    => Mage::helper('bannerslider')->__('Internal Js'),
            'title'    => Mage::helper('bannerslider')->__('Internal Js'),
            'style'    => 'width:500px; height:100px;',
            'required' => false,
        ));

        $fieldset->addField('css_text', 'editor', array(
            'name'     => 'css_text',
            'label'    => Mage::helper('bannerslider')->__('Internal Css'),
            'title'    => Mage::helper('bannerslider')->__('Internal Css'),
            'style'    => 'width:500px; height:100px;',
            'wysiwyg'  => false,
            'required' => false,
        ));
        $form->setValues($data);

        return parent::_prepareForm();
    }
}
