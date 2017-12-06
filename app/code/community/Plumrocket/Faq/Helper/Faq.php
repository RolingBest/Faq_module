<?php
class DS_News_Helper_Faq extends Mage_Core_Helper_Abstract
{
	public function getIsEnabled()
	{
		return Mage::getStoreConfigFlag('section/group/enable');
	}
	public function getSomething($params)
	{
		if (!Mage::helper('plumrocket_faq')->getIsEnabled()) { 
			return parent::getSomething($params);
		}
		
	}
}