<?php

class Plumrocket_Faq_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
		if (Mage::getStoreConfig('faq_section/settings/enable')) {
            $this->loadLayout();
			$this->renderLayout();
        } else {
            $this->_forward('noRoute');
        }
    
        
    }

    public function viewAction()
    {
		
		if (Mage::getStoreConfig('faq_section/settings/enable')) {
            $this->loadLayout();
			$this->renderLayout();
        } else {
            $this->_forward('noRoute');
        }
	}
}