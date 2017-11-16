<?php

class Plumrocket_Faq_Block_Faqs extends Mage_Core_Block_Template
{

    public function getFaqsCollection()
    {
        $faqsCollection = Mage::getModel('plumrocketfaq/faqs')->getCollection();
        $faqsCollection->setOrder('created', 'DESC');
        return $faqsCollection;
    }

}