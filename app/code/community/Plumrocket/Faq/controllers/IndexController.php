<?php

class Plumrocket_Faq_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
		$faqsId = Mage::app()->getRequest()->getParam('id', 0);
		$faqs = Mage::getModel('plumrocketfaq/faqs')->load($faqsId);
		

        if ($faqs->getId() > 0) {
            $this->loadLayout();
            
			/*$this->getLayout()->getBlock('faqs.content')->assign(array(
                "faqsItem" => $faqs,
            ));*/
            $this->renderLayout();
        } else {
            $this->_forward('noRoute');
        }

    }
}