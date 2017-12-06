<?php

class Plumrocket_Faq_Block_View extends Mage_Core_Block_Template
{
	public function getItem() 
	{
		$faqsId = Mage::app()->getRequest()->getParam('id', 0);
		$faqs = Mage::getModel('plumrocketfaq/faqs')->load($faqsId);
		
		return $faqs;
		
	}
}	