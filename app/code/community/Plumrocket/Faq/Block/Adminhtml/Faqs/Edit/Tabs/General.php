<?php

class Plumrocket_Faq_Block_Adminhtml_Faqs_Edit_Tabs_General extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {

        $helper = Mage::helper('plumrocketfaq');
        $model = Mage::registry('current_faqs');


        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('general_form', array(
                    'legend' => $helper->__('General Information')
                ));

        $fieldset->addField('title', 'text', array(
            'label' => $helper->__('Title'),
            'required' => true,
            'name' => 'title',
        ));

        $fieldset->addField('content', 'editor', array(
            'label' => $helper->__('Content'),
            'required' => true,
            'name' => 'content',
        ));

        $fieldset->addField('is_active', 'text', array(
            'label' => $helper->__('is_active'),
			'required' => true,
            'name' => 'is_active',
        ));

		
		$form->setValues($formData);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}