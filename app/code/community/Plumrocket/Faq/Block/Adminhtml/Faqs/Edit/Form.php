<?php

class Plumrocket_Faq_Block_Adminhtml_Faqs_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareLayout()
	{
		$return = parent::_prepareLayout();
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
		}
	}
	
	protected function _prepareForm()
    {
		
        $helper = Mage::helper('plumrocketfaq');
        $model = Mage::registry('current_faqs');

        $form = new Varien_Data_Form(array(
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save', array(
                        'id' => $this->getRequest()->getParam('id')
                    )),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ));

        $this->setForm($form);

        $fieldset = $form->addFieldset('faqs_form', array('legend' => $helper->__('Faqs Information')));

        $fieldset->addField('title', 'text', array(
            'label' => $helper->__('Title'),
            'required' => true,
            'name' => 'title',
        ));

        $fieldset->addField('content', 'editor', array(
            //'label' => Mage::helper('editor')->__('Content'),
			'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
			'style' => 'height:36em;',
            'required' => true,
            'name' => 'content',
        ));

        $fieldset->addField('is_active', 'select', array(
			'values' => array('0' => 'disable','1' => 'enable'),
            'label' => $helper->__('is_active'),
            'name' => 'is_active'
        ));

        $form->setUseContainer(true);

        if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
            $form->setValues($data);
        } else {
            $form->setValues($model->getData());
        }

        return parent::_prepareForm();
    
    }

    
    
}