<?php

class Plumrocket_Faq_Block_Faqs extends Mage_Core_Block_Template
{

    public function getFaqsCollection()
    {
        $faqsCollection = Mage::getModel('plumrocketfaq/faqs')
								->getCollection()
								->addFieldToFilter('is_active', 1)
								->setOrder('title', 'ASC');
	   return $faqsCollection;
    }

}