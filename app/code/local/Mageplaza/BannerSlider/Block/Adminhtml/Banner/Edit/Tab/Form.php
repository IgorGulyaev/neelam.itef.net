<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Banner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $banner = Mage::registry('current_banner');
        if (Mage::getSingleton('adminhtml/session')->getFormData()) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);
            $banner->setData($data);
        }
        $fieldset = $form->addFieldset('banner_form', array(
            'legend' => Mage::helper('bannerslider')->__('Banner Information')
        ));

        $fieldset->addField('title', 'text', array(
            'label'    => Mage::helper('bannerslider')->__('Title'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => 'title',

        ));
        $statusArray = Mage::getModel('bannerslider/banner')->getOptionArray();

        $fieldset->addField('status', 'select', array(
            'label'  => Mage::helper('bannerslider')->__('Status'),
            'name'   => 'status',
            'values' => $statusArray
        ));
        $fieldset->addField('type_id', 'select', array(
            'label'    => Mage::helper('bannerslider')->__('Banner Type'),
            'name'     => 'type_id',
            'required' => true,
            'onchange' => 'showFileField()',
            'values'   => Mage::getModel('bannerslider/banner')->getTypeArray(),
        ));

        if ($banner->getData('source_file'))
            $isRequired = false;
        else
            $isRequired = true;
        $fieldset->addField('source_file', 'file', array(
            'label'    => Mage::helper('bannerslider')->__('Source File'),
            'name'     => 'source_file',
            'required' => $isRequired,
        ));
        if ($bannerId = $banner->getData('banner_id') && $banner->getData('source_file')) {
            $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'mageplaza/bannerslider/banner/';
            if ($banner->getWidth() == 0 || $banner->getHeight() == 0) {
                $fieldset->addField('banner_view', 'note', array(
                    'label'              => Mage::helper('bannerslider')->__('Banner View'),
                    'text'               => $this->getLayout()->createBlock('bannerslider/adminhtml_banner_view')
                        ->setBannerType($banner->getData('type_id'))
                        ->setFile($url . $banner->getData('source_file'))
                        ->toHtml(),
                    'after_element_html' => '<button id="delete_banner_file" type="button"
                        onclick="window.location.href=\'' . $this->getUrl('*/*/deleteFile', array('banner_id' => $bannerId, 'source_file' => $banner->getData('source_file'))) . '\'"
                        class="delete"><span>' . $this->__('Delete') . '</span></button>'
                ));
            } else {
                $fieldset->addField('banner_view', 'note', array(
                    'label' => Mage::helper('bannerslider')->__('Banner View'),
                    'text'  => $this->getLayout()->createBlock('bannerslider/adminhtml_banner_view')
                        ->setBannerType($banner->getData('type_id'))
                        ->setFile($url . $banner->getData('source_file'))
                        ->setWidth($banner->getData('width'))
                        ->setHeight($banner->getData('height'))
                        ->toHtml(),
                ));
            }

        }
        $sizeFixOption = Mage::getModel('bannerslider/banner')->getSizeFix();

        $fieldset->addField('fix_size', 'select', array(
            'label'    => Mage::helper('bannerslider')->__('Fix Size'),
            'name'     => 'fix_size',
            'onchange' => 'showFixImage()',
            'values'   => $sizeFixOption
        ));
        $fieldset->addField('width', 'text', array(
            'label'    => Mage::helper('bannerslider')->__('Width (px)'),
            'required' => true,
            'name'     => 'width',

        ));

        $fieldset->addField('height', 'text', array(
            'label'    => Mage::helper('bannerslider')->__('Height (px)'),
            'required' => true,
            'name'     => 'height',
        ));


        $fieldset->addField('link', 'text', array(
            'label'    => Mage::helper('bannerslider')->__('Link'),
            'name'     => 'link',
            'required' => true,
            'class'    => 'validate-url'
        ));


        $form->addValues($banner->getData());

        Mage::dispatchEvent('bannerslider_adminhtml_banner_form_form', array(
            'form'     => $form,
            'fieldset' => $fieldset
        ));

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
