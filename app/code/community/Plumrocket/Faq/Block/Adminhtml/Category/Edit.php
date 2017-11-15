<?php

class Plumrocket_Faq_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'category_id';
        $this->_blockGroup = 'plumrocket_faq';
        $this->_controller = 'adminhtml_category';
        
        parent::__construct();
        
        $this->_updateButton('save', 'label', Mage::helper('plumrocket_faq')->__('Save FAQ Category'));
        $this->_updateButton('delete', 'label', Mage::helper('plumrocket_faq')->__('Delete FAQ Category'));
        
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
    
    public function getCategory()
    {
        return Mage::registry('faq_category');
    }
    
    public function getHeaderText()
    {
        if ($this->getCategory()->getId()) {
            return $this->escapeHtml($this->getCategory()->getCategoryName());
        } else {
            return $this->escapeHtml(Mage::helper('plumrocket_faq')->__('New FAQ Category'));
        }
    }
    
    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save');
    }

    public function getHeaderCssClass()
    {
        return '';
    }
}