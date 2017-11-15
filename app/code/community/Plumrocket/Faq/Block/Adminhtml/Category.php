<?php

class Plumrocket_Faq_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    
    public function __construct()
    {
        $this->_blockGroup = 'plumrocket_faq';
        $this->_controller = 'adminhtml_category';
        $this->_headerText = Mage::helper('plumrocket_faq')->__('Manage FAQ Categories');
        $this->_addButtonLabel = Mage::helper('plumrocket_faq')->__('Add New FAQ Category');
        
        parent::__construct();
    }
    
    public function getHeaderCssClass()
    {
        return '';
    }
}