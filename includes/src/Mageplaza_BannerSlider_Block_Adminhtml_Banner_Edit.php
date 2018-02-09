<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Banner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    const PAGE_TABS_BLOCK_ID = 'banner_tabs';
    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'bannerslider';
        $this->_controller = 'adminhtml_banner';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('bannerslider')->__('Save Banner'));
        $this->_updateButton('delete', 'label', Mage::helper('bannerslider')->__('Delete Banner'));

        $this->_addButton('saveandcontinue', array(
            'label'   => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
            'class'   => 'save',
        ), -100);


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


            function showFixImage(){
            var width = $('width').up('tr');
			var height = $('height').up('tr');
			if($('fix_size').getValue() == 1)
			{
            $('width').addClassName('required-entry');
			$('height').addClassName('required-entry');
			width.show();
			height.show();
			}
			else
			{
                    $('width').removeClassName('required-entry');
					$('height').removeClassName('required-entry');
					width.hide();
					height.hide();
			}
            }
	function showFileField(){
				var view = $('banner_view');
				if($('type_id').getValue() == 1 || $('type_id').getValue() == 2){
					if(view != null || view != undefined){
						view.up('tr').show();
						$('source_file').removeClassName('required-entry');
					}
				}
			}
			showFileField();
			showFixImage();

        ";

    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current' => true,
            'back'     => 'edit',
            'tab'      => '{{tab_id}}'
        ));
    }

    public function getHeaderText()
    {
        if (Mage::registry('current_banner')->getId()) {
            return Mage::helper('bannerslider')->__("Edit Banner '%s'", $this->escapeHtml(Mage::registry('current_banner')->getTitle()));
        } else {
            return Mage::helper('bannerslider')->__('New Banner');
        }
    }
}