<?php

class Plumrocket_Faq_Block_Adminhtml_Faqs_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    protected function _construct()
    {
        $this->_blockGroup = 'plumrocketfaq';
        $this->_controller = 'adminhtml_faqs';
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('plumrocketfaq');
        $model = Mage::registry('current_faqs');

        if ($model->getId()) {
            return $helper->__("Edit Faqs item '%s'", $this->escapeHtml($model->getTitle()));
        } else {
            return $helper->__("Add Faqs item");
        }
    }

}