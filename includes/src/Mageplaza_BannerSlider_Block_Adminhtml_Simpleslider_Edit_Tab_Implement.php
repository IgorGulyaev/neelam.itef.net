<?php

class Mageplaza_BannerSlider_Block_Adminhtml_Simpleslider_Edit_Tab_Implement extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $slider = Mage::registry('current_simpleslider');
        if (Mage::getSingleton('adminhtml/session')->getFormData()) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);
            $slider->setData($data);
        }
        $fieldset = $form->addFieldset('bannerslider_implement', array(
            'legend' => Mage::helper('bannerslider')->__('Implement')
        ));


        $this->setForm($form);

        return parent::_prepareForm();
    }


    /**
     * Reference: https://gist.github.com/anonymous/82b51225725de4cbffef
     * @return string
     */
    public function getFormHtml()
    {

        $slider = Mage::registry('current_simpleslider');

        return '
            <div class="entry-edit-head collapseable"><a onclick="Fieldset.toggleCollapse(\'slider_template\'); return false;" href="#" id="slider_template-head" class="open">Implement Code ( You can ignore this section if you have ready selected <strong>Position</strong> for this slider)</a></div>
            <fieldset id="simple_slider_template" class="config collapseable" style="">
            <h4 class="icon-head head-edit-form fieldset-legend">Add the following code for your project</h4>

            <div id="messages">
                <ul class="messages">
                    <li class="notice-msg">
                        <ul>
                            <li>' . $this->__('Apply for Template File .phtml') . '</li>
                        </ul>
                    </li>
                </ul>
            </div>
            <br>
            <ul>
                <li>
                    <p>
                    <code>
                     $this->getLayout()->createBlock(\'bannerslider/simpleslider\')->setTemplate(\'mageplaza/bannerslider/simpleslider.phtml\')->setSimpleSliderId(\'' . $slider->getId() . '\')->toHtml();
                    </code>
                    </p>
                </li>
            </ul>
            <br>
            <div id="messages">
                <ul class="messages">
                    <li class="notice-msg">
                        <ul>
                            <li>' . $this->__('Apply for CMS Page, Static Block') . '</li>
                        </ul>
                    </li>
                </ul>
            </div>
            <br>
            <ul>
                <li>
                    <code>
                    {{block type="bannerslider/simpleslider" name="simple.slider" template="mageplaza/bannerslider/simpleslider.phtml" simple_slider_id=\'' . $slider->getId() . '\'}}
                    </code>
                </li>
            </ul>
            <br>
            <div id="messages">
                <ul class="messages">
                    <li class="notice-msg">
                        <ul>
                            <li>' . $this->__('Apply for XML layout') . '</li>
                        </ul>
                    </li>
                </ul>
            </div>

            <ul>
                <li>
                    <code>
                     &lt;block type="bannerslider/simpleslider" name="simple.slider" template="mageplaza/bannerslider/simpleslider.phtml"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;action method="setSimpleSliderId"&gt;&lt;simple_slider_id&gt;' . $slider->getId() . '&lt;/simple_slider_id&gt;&lt;/action&gt;<br>
                    &lt;/block&gt;
                    </code>
                </li>
            </ul>
            <br>
            <div id="messages">
                <ul class="messages">
                    <li class="notice-msg">
                        <ul>
                            <li>' . $this->__('Display on the left of category pages.') . '</li>
                        </ul>
                    </li>
                </ul>
            </div>
            <br>
            <ul>
                <li>
                    <code>
                    &lt;?xml version="1.0"?&gt;<br>
            &lt;layout version="0.1.0"&gt;<br>
            &nbsp;&nbsp;&lt;catalog_category_default&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;reference name="left"&gt;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;block type="catalog/navigation" name="catalog.leftnav" after="currency" template="catalog/navigation/left.phtml"/&gt;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;block type="bannerslider/simpleslider" name="simple.slider.block" template="mageplaza/bannerslider/simpleslider.phtml"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;action method="setSimpleSliderId"&gt;&lt;simple_slider_id&gt;' . $slider->getId() . '&lt;/simple_slider_id&gt;&lt;/action&gt;<br>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/block&gt; <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;/reference><br>
            &nbsp;&nbsp;&lt;/catalog_category_default&gt;<br>
            &lt;/layout&gt;
            </code>
                </li>
            </ul>
            <br>
            
            </fieldset>

		';
    }
}