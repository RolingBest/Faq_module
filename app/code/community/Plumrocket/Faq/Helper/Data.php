<?php

class Plumrocket_Faq_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function moduleEnabled()
    {
        return (bool)Mage::getStoreConfig('faq_section/settings/enable');
    }

}	