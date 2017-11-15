<?php

class Plumrocket_Faq_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    public function getConfigData($field)
    {
        $path = 'faq/config/' . $field;
        $config = Mage::getStoreConfig($path, Mage::app()->getStore());
        return $config;
    }
    
    public function getFaqIndexUrl()
    {
        return $this->_getUrl('faq');
    }
}