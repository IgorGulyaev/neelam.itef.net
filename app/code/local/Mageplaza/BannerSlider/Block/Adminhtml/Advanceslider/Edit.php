<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Advanceslider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    const PAGE_TABS_BLOCK_ID = 'advanceslider_tabs';

    public function __construct()
    {
        parent::__construct();

        $this->_objectId   = 'id';
        $this->_blockGroup = 'bannerslider';
        $this->_controller = 'adminhtml_advanceslider';

        $this->_updateButton('save', 'label', Mage::helper('bannerslider')->__('Save'));
        $this->_updateButton('save', 'onclick', 'processEditorQueue();editForm.submit();');
        $this->_updateButton('delete', 'label', Mage::helper('bannerslider')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
            'label'   => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
            'class'   => 'save',
        ), -100);
        $data = Mage::registry('advanceslider_data');
        if (isset($data['banner_html'])) {
            $bannerHtml  = Mage::helper('core')->jsonDecode($data['banner_html']);
            $bannerCount = count($bannerHtml);
        } else {
            $bannerCount = 1;
        }
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('bannerslider_content') == null)
                    tinyMCE.execCommand('mceAddControl', false, 'bannerslider_content');
                else
                    tinyMCE.execCommand('mceRemoveControl', false, 'bannerslider_content');
            }

            function saveAndContinueEdit(urlTemplate){
                processEditorQueue()
                var urlTemplateSyntax = /(^|.|\\r|\\n)({{(\\w+)}})/;
                var template = new Template(urlTemplate, urlTemplateSyntax);
                var url = template.evaluate({tab_id:" . self::PAGE_TABS_BLOCK_ID . "JsTabs.activeTab.id});
                editForm.submit(url);
            }
            var skyAdvSlider=new SkyBannerSliderAdvanced({
                bannerLable: '" . $this->__('Banner') . "',
                removeLable: '" . $this->__('Remove') . "',
                errorMsg: '" . $this->__('Must have at least one banner ') . "',
                bannerCount: " . $bannerCount . ",
                addMoreEl: 'add_banner_text',
                removeClass: '.remove-banner-text',
            })
            $('advanceslider_tabs_content_section').observe('click',function(){
                processEditorQueue();
            })
        ";
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

    /**
     * get text to show in header when edit an item
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('advanceslider_data')
            && Mage::registry('advanceslider_data')->getId()
        ) {
            return Mage::helper('bannerslider')->__("Edit Slider '#%s'",
                $this->htmlEscape(Mage::registry('advanceslider_data')->getId())
            );
        }

        return Mage::helper('bannerslider')->__('Add Slider');
    }
}