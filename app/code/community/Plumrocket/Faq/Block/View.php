<?php

class Plumrocket_Faq_Block_View extends Mage_Core_Block_Template
{
	public function viewAction() 
	{

		$this->getLayout()->getBlock('faqs.content')->assign(array(
				"faqsItem" => $faqs,
			));

	}
}	