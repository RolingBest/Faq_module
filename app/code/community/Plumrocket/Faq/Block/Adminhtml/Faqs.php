<?php

class Plumrocket_Faq_Block_Adminhtml_Faqs extends  Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('plumrocketfaq');
        $this->_blockGroup = 'plumrocketfaq';
        $this->_controller = 'adminhtml_faqs';

        $this->_headerText = $helper->__('Faqs Management');
        $this->_addButtonLabel = $helper->__('Add Faqs');
    }

}