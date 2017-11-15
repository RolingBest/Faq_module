<?php

class Plumrocket_Faq_Block_Adminhtml_Item_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	
	public function __construct()
	{
		$this->_objectId = 'faq_id';
        $this->_blockGroup = 'plumrocket_faq';
		$this->_controller = 'adminhtml_item';
		
		parent::__construct();
		
		$this->_updateButton('save', 'label', Mage::helper('plumrocket_faq')->__('Save FAQ item'));
		$this->_updateButton('delete', 'label', Mage::helper('plumrocket_faq')->__('Delete FAQ item'));
		
		$this->_addButton('saveandcontinue', array (
				'label' => Mage::helper('plumrocket_faq')->__('Save and continue edit'), 
				'onclick' => 'saveAndContinueEdit()', 
				'class' => 'save' ), -100);
		
		$this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
	}
	
	
	public function getHeaderText()
	{
		if (Mage::registry('faq')->getFaqId()) {
			return Mage::helper('plumrocket_faq')->__("Edit FAQ item '%s'", $this->htmlEscape(Mage::registry('faq')->getQuestion()));
		}
		else {
			return Mage::helper('plumrocket_faq')->__('New FAQ item');
		}
	}
	
	public function getFormActionUrl()
	{
        return $this->getUrl('*/faq/save');
    }
  
    public function getHeaderCssClass()
    {
        return '';
    }
}