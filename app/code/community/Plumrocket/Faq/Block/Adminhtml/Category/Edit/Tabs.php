<?php

class Plumrocket_Faq_Block_Adminhtml_Category_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('faq_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('plumrocket_faq')->__('Category Information'));
    }
    
    protected function _prepareLayout()
    {
        $return = parent::_prepareLayout();
        $this->addTab(
            'main_section', 
            array(
                'label' => Mage::helper('plumrocket_faq')->__('General information'),
                'title' => Mage::helper('plumrocket_faq')->__('General information'),
                'content' => $this->getLayout()->createBlock('plumrocket_faq/adminhtml_category_edit_tab_main')->toHtml(),
                'active' => true,
            )
        );
        
        return $return;
    }
}