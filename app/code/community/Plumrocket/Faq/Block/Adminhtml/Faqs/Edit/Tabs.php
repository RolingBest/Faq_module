<?php

class Plumrocket_Faq_Block_Adminhtml_Faqs_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        $helper = Mage::helper('plumrocketfaq');

        parent::__construct();
        $this->setId('faq_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($helper->__('Faqs Information'));
    }

    protected function _prepareLayout()
    {
        $helper = Mage::helper('plumrocketfaq');

        $this->addTab('general_section', array(
            'label' => $helper->__('General Information'),
            'title' => $helper->__('General Information'),
            'content' => $this->getLayout()->createBlock('plumrocketfaq/adminhtml_faqs_edit_tabs_general')->toHtml(),
        ));
        $this->addTab('custom_section', array(
            'label' => $helper->__('Custom Fields'),
            'title' => $helper->__('Custom Fields'),
            'content' => $this->getLayout()->createBlock('plumrocketfaq/adminhtml_faqs_edit_tabs_custom')->toHtml(),
        ));
        return parent::_prepareLayout();
    }

}