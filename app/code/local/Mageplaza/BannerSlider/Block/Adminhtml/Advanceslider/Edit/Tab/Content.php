<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Advanceslider_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form
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
            $data       = Mage::getSingleton('adminhtml/session')->getAdvanceSliderData();
            $bannerHtml = Mage::helper('core')->jsonDecode($data->getBannerHtml());
            Mage::getSingleton('adminhtml/session')->setAdvanceSliderData(null);
        } elseif (Mage::registry('advanceslider_data')) {
            $data       = Mage::registry('advanceslider_data');
            $bannerHtml = Mage::helper('core')->jsonDecode($data->getBannerHtml());
            $bannerArr  = array('banner_html' => $bannerHtml);
            $data->addData($bannerArr);

            $data = $data->getData();

        }
        $fieldset = $form->addFieldset('advanceslider_form', array(
            'legend' => Mage::helper('bannerslider')->__('Html Content')
        ));
        $fieldset->addField('prefix', 'textarea', array(
            'name'    => 'prefix',
            'label'   => Mage::helper('bannerslider')->__('Prefix HTML'),
            'title'   => Mage::helper('bannerslider')->__('Prefix HTML'),
            'style'   => 'width:500px; height:20px;',
            'wysiwyg' => false,
            'after_element_html'=>'<br> <br> <hr> <br>',
        ));
        $fieldset->addField('suffix', 'textarea', array(
            'name'    => 'suffix',
            'label'   => Mage::helper('bannerslider')->__('Suffix HTML'),
            'title'   => Mage::helper('bannerslider')->__('Suffix HTML'),
            'style'   => 'width:500px; height:20px;',
            'wysiwyg' => false,
            'after_element_html'=>'<br> <br> <hr> <br>',
        ));
        if (isset($data['banner_html'])) {
            $key     = $data['banner_html'];
            $lastKey = key(array_slice($key, -1, 1, true));
            foreach ($data['banner_html'] as $key => $value) {
                if ($key == $lastKey) {
                    $fieldset->addField('banner_html_' . $key, 'textarea', array(
                        'name'               => 'banner_html[' . $lastKey . ']',
                        'label'              => Mage::helper('bannerslider')->__('Banner %s', $key),
                        'title'              => Mage::helper('bannerslider')->__('Banner %s', $key),
                        'style'              => 'width:500px; height:100px;',
                        'class'              => 'banner-text',
                        'after_element_html' => '
	                    <tr>
							<td class="label"><label for="banner_html_1">&nbsp;</label></td>
							<td class="value"><button class="delete remove-banner-text" onclick="skyAdvSlider.removeBannerText(this)" id="remove_banner_text_' . $key . '" type="button"><span>' . $this->__('Remove') . '</span></button></td>
						</tr>
						<tr>
							<td class="label"><label for="banner_html_1">&nbsp;</label></td>
							<td class="value">
							<button class="add" id="add_banner_text" type="button"><span>' . $this->__('Add More') . '</span></button>
							<br> <br> <hr> <br>
							</td>
						</tr>

					',


                    ));
                } else {
                    $fieldset->addField('banner_html_' . $key, 'textarea', array(
                        'name'               => 'banner_html[' . $key . ']',
                        'label'              => Mage::helper('bannerslider')->__('Banner %s', $key),
                        'title'              => Mage::helper('bannerslider')->__('Banner %s', $key),
                        'style'              => 'width:500px; height:100px;',
                        'class'              => 'banner-text',
                        'after_element_html' => '
						<tr>
							<td class="label"><label for="banner_html_1">&nbsp;</label></td>
							<td class="value"><button class="delete remove-banner-text" onclick="skyAdvSlider.removeBannerText(this)" id="remove_banner_text_' . $key . '" type="button"><span>' . $this->__('Remove') . '</span></button>
							<br> <br> <hr> <br>
							</td>
						</tr>

					'
                    ));
                }
                $data['banner_html_' . $key] = $value;

            }
            $data['banner_html_' . $key] = $value;
        } else {
            $fieldset->addField('banner_html_1', 'textarea', array(
                'name'               => 'banner_html[1]',
                'label'              => Mage::helper('bannerslider')->__('Banner 1'),
                'title'              => Mage::helper('bannerslider')->__('Banner 1'),
                'style'              => 'width:500px; height:100px;',
                'required'           => true,
                'class'              => 'banner-text',
                'after_element_html' => '
				<tr>
					<td class="label"><label for="banner_html_1">&nbsp;</label></td>
					<td class="value"><button class="add" id="add_banner_text" type="button"><span>' . $this->__('Add Slider') . '</span></button>
					</td>

				</tr>

				',

            ));
        }

        $fieldset->addField('html_text', 'textarea', array(
            'name'     => 'html_text',
            'label'    => Mage::helper('bannerslider')->__('Additional HTML'),
            'title'    => Mage::helper('bannerslider')->__('Additional HTML'),
            'style'    => 'width:500px; height:20px;',
            'required' => false,
        ));
        $form->setValues($data);

        return parent::_prepareForm();
    }
}
