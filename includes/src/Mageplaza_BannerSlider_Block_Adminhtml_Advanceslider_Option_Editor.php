<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Advanceslider_Option_Editor extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        parent::_prepareLayout();
        if($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::AUTO_COMPLETE){
            $this->setTemplate('mageplaza/bannerslider/editor/autocomplete.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::SUBLIME_TEXT){
            $this->setTemplate('mageplaza/bannerslider/editor/sublime.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::CODE_FOLDING){
            $this->setTemplate('mageplaza/bannerslider/editor/codefolding.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::LANGUAGE_MODE){
            $this->setTemplate('mageplaza/bannerslider/editor/languagemode.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::FONT_SIZE){
            $this->setTemplate('mageplaza/bannerslider/editor/fontsize.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::SEARCH_INTERFACE){
            $this->setTemplate('mageplaza/bannerslider/editor/searchinterface.phtml');
//        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::VIM_BINDINGS){
//            $this->setTemplate('mageplaza/bannerslider/editor/vimbindings.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::EMACS_BINDINGS){
            $this->setTemplate('mageplaza/bannerslider/editor/emacsbindings.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::FULL_SCREEN_EDITOR){
            $this->setTemplate('mageplaza/bannerslider/editor/fullscreen.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::BI_DIRECTION_TEXT){
            $this->setTemplate('mageplaza/bannerslider/editor/bidi.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::TERN_INTEGRATION){
            $this->setTemplate('mageplaza/bannerslider/editor/tern.phtml');
        }elseif($this->getOptionEditor()==Mageplaza_BannerSlider_Model_System_Config_Source_Editor::CUSTOM_SCROLL_BARS){
            $this->setTemplate('mageplaza/bannerslider/editor/scrollbars.phtml');
        }
            return $this;
    }
    public function getOptionEditor(){
        return Mage::helper('bannerslider')->getEditor();
    }
}