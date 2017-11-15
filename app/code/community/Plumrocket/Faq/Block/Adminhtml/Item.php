<?php

class Plumrocket_Faq_Block_Adminhtml_Item extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'plumrocket_faq';
        $this->_controller = 'adminhtml_item';
        $this->_headerText = Mage::helper('plumrocket_faq')->__('Manage FAQ Items');
        $this->_addButtonLabel = Mage::helper('plumrocket_faq')->__('Add New FAQ Item');
        
        parent::__construct();
    }
    
    public function getHeaderCssClass()
    {
        return '';
    }
}