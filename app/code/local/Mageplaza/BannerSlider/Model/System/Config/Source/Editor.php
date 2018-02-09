<?php

class Mageplaza_BannerSlider_Model_System_Config_Source_Editor extends Mage_Core_Model_Config_Data
{

    const AUTO_COMPLETE = 'autocompletetion';
    const CODE_FOLDING = 'Code folding';
    const THEMES = 'Themes';
    const LANGUAGE_MODE = 'Mixed language modes';
    const BI_DIRECTION_TEXT = 'Bi-directional text';
    const FONT_SIZE = 'Variable font sizes';
    const SEARCH_INTERFACE = 'Search interface';
    const VIM_BINDINGS = 'Vim bindings';
    const EMACS_BINDINGS = 'Emacs bindings';
    const SUBLIME_TEXT = 'Sublime Text bindings';
    const TERN_INTEGRATION = 'Tern integration';
    const MERGE_INTERFACE = 'Merge/diff interface';
    const FULL_SCREEN_EDITOR = 'Full-screen editor';
    const CUSTOM_SCROLL_BARS = 'Custom scrollbars';

    public function toOptionArray()
    {
        $array = array(
            array('value' => self::AUTO_COMPLETE, 'label' => Mage::helper('bannerslider')->__('Auto Completetion')),
//            array('value' => self::CODE_FOLDING, 'label' => Mage::helper('bannerslider')->__('Code folding')),
//            array('value' => self::THEMES, 'label' => Mage::helper('bannerslider')->__('Themes')),
            array('value' => self::LANGUAGE_MODE, 'label' => Mage::helper('bannerslider')->__('Mixed language modes')),
            array('value' => self::BI_DIRECTION_TEXT, 'label' => Mage::helper('bannerslider')->__('Bi-directional text')),
            array('value' => self::FONT_SIZE, 'label' => Mage::helper('bannerslider')->__('Variable font sizes')),
            array('value' => self::SEARCH_INTERFACE, 'label' => Mage::helper('bannerslider')->__('Search interface')),
            array('value' => self::VIM_BINDINGS, 'label' => Mage::helper('bannerslider')->__('Vim bindings')),
            array('value' => self::EMACS_BINDINGS, 'label' => Mage::helper('bannerslider')->__('Emacs bindings')),
            array('value' => self::SUBLIME_TEXT, 'label' => Mage::helper('bannerslider')->__('Sublime Text bindings')),
            array('value' => self::TERN_INTEGRATION, 'label' => Mage::helper('bannerslider')->__('Tern integration')),
//            array('value' => self::MERGE_INTERFACE, 'label' => Mage::helper('bannerslider')->__('Merge/diff interface')),
            array('value' => self::FULL_SCREEN_EDITOR, 'label' => Mage::helper('bannerslider')->__('Full-screen editor')),
            array('value' => self::CUSTOM_SCROLL_BARS, 'label' => Mage::helper('bannerslider')->__('Custom scrollbars')),
        );

        $container = new Varien_Object(array('array' => $array));

        return $container->getArray();
    }

}