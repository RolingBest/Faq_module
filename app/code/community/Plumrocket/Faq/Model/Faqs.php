<?php

class Plumrocket_Faq_Model_Faqs extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('plumrocketfaq/faqs');
    }

	 protected function _afterDelete()
    {
        $helper = Mage::helper('plumrocketfaq');
        @unlink($helper->getImagePath($this->getId()));
        return parent::_afterDelete();
    }

    public function getImageUrl()
    {
        $helper = Mage::helper('plumrocketfaq');
        if ($this->getId() && file_exists($helper->getImagePath($this->getId()))) {
            return $helper->getImageUrl($this->getId());
        }
        return null;
    }
}
