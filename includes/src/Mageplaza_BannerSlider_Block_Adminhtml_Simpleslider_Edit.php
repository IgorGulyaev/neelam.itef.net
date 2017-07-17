<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Simpleslider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    const PAGE_TABS_BLOCK_ID = 'simpleslider_tabs';

    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'bannerslider';
        $this->_controller = 'adminhtml_simpleslider';
        parent::__construct();
        $slider = Mage::registry('current_simpleslider');
        $this->_addButton('saveandcontinue', array(
            'label'   => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
            'class'   => 'save',
        ), -100);
        if ($slider && $slider->getId()) {
            $this->_addButton('preview', array(
                'label'   => Mage::helper('adminhtml')->__('Preview'),
                'onclick' => 'previewSlider(\'' . $this->_getPreviewUrl() . '\')',
                'class'   => 'preview',
            ), -200);
        }
        if ($this->getRequest()->getParam('type', false) == 'carousel') {
            $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/*/carousel') . '\')');
            Mage::register('type', 'carousel');
        }
        if ($this->getRequest()->getParam('type', false) == 'popup') {
            $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/*/popup') . '\')');
            Mage::register('type', 'popup');
        }
        if ($this->getRequest()->getParam('type', false) == 'note') {
            $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/*/note') . '\')');
            Mage::register('type', 'note');
        }
        if ($this->getRequest()->getParam('type', false) == 'flex') {
            $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/*/flex') . '\')');
            Mage::register('type', 'flex');
        }
        $this->_addButton('save', array(
            'label'   => Mage::helper('adminhtml')->__('Save Slider'),
            'onclick' => 'saveSlider(\'' . Mage::helper('adminhtml')->__('')
                . '\', \'' . $this->saveSliderUrl() . '\')',
            'class'   => 'save',
        ), 1);
        $this->_formScripts[] = "
					function saveSlider(message, url){
							editForm.submit(url);
					}
				";
        $this->_addButton('delete', array(
            'label'   => Mage::helper('adminhtml')->__('Delete Slider'),
            'class'   => 'delete',
            'onclick' => 'deleteConfirm(\'' . Mage::helper('adminhtml')->__('Are you sure you want to do this?')
                . '\', \'' . $this->getDeleteUrl() . '\')',
        ));
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('bannerslider_content') == null)
                    tinyMCE.execCommand('mceAddControl', false, 'bannerslider_content');
                else
                    tinyMCE.execCommand('mceRemoveControl', false, 'bannerslider_content');
            }

            function saveAndContinueEdit(urlTemplate){
                var urlTemplateSyntax = /(^|.|\\r|\\n)({{(\\w+)}})/;
                var template = new Template(urlTemplate, urlTemplateSyntax);
                var url = template.evaluate({tab_id:" . self::PAGE_TABS_BLOCK_ID . "JsTabs.activeTab.id});
                editForm.submit(url);
            }
            function previewSlider(url){
                  var win = window.open(url, '_blank');
                  win.focus();
            }
        ";

        Mage::dispatchEvent('bannerslider_adminhtml_simpleslider_edit_header', array(
            'block'  => $this,
            'object' => $slider
        ));
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array(
            'id'   => $this->getRequest()->getParam('id'),
            'type' => $this->getRequest()->getParam('type')
        ));
    }

    protected function _getPreviewUrl()
    {
        return $this->getUrl('*/*/preview', array(
            'id'   => $this->getRequest()->getParam('id'),
            'type' => $this->getRequest()->getParam('type')
        ));
    }

    public function saveSliderUrl()
    {
        return $this->getUrl('*/*/save', array(
            'id'   => $this->getRequest()->getParam('id'),
            'type' => $this->getRequest()->getParam('type')
        ));
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
            'tab'        => '{{tab_id}}',
            'active_tab' => null
        ));
    }

    public function getHeaderText()
    {
        if (Mage::registry('current_simpleslider')
            && Mage::registry('current_simpleslider')->getId()
        ) {
            return Mage::helper('bannerslider')->__("Edit Slider '#%s'",
                $this->htmlEscape(Mage::registry('current_simpleslider')->getId())
            );
        }

        return Mage::helper('bannerslider')->__('Add Slider');
    }
}