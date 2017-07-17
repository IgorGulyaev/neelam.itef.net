<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Simpleslider_Edit_Tab_Rule
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare content for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('salesrule')->__('Conditions');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('salesrule')->__('Conditions');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $id=$this->getRequest()->getParam('id');
        $simpleSlider=Mage::getModel('bannerslider/simpleslider')->load($id);
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('rule_');

        $renderer = Mage::getBlockSingleton('adminhtml/widget_form_renderer_fieldset')
            ->setTemplate('promo/fieldset.phtml')
            ->setNewChildUrl($this->getUrl('bannerslider/adminhtml_simpleslider/newConditionHtml/form/rule_conditions_fieldset'));

        $fieldset = $form->addFieldset('conditions_fieldset', array(
            'legend' => Mage::helper('bannerslider')->__('Apply the rule only if the following conditions are met (leave blank for all products)'),
        ))
            ->setRenderer($renderer);

        $fieldset->addField('conditions', 'text', array(
            'name'     => 'conditions',
            'label'    => Mage::helper('bannerslider')->__('Conditions'),
            'title'    => Mage::helper('bannerslider')->__('Conditions'),
            'required' => true,
        ))
            ->setRule($simpleSlider)
            ->setRenderer(Mage::getBlockSingleton('rule/conditions'));

        $form->setValues($simpleSlider->getData());
        $this->setForm($form);

        Mage::dispatchEvent('bannerslider_simpleslider_edit_tab_rule_prepare_form', array(
            'form' => $form
        ));
        return parent::_prepareForm();
    }
}