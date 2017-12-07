<?php

class Plumrocket_Faq_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function __construct() 
	{
		$resource = Mage::getSingleton('core/resource');
		$writeConnection = $resource->getConnection('core_write');
	
		if (Mage::getStoreConfig('faq_section/settings/enable')) {
			$query = "UPDATE `core_config_data` SET `value` = 0 
					WHERE `core_config_data`.`path` LIKE '%Plumrocket_Faq%';";
		} else {
			$query = "UPDATE `core_config_data` SET `value` = 1 
					WHERE `core_config_data`.`path` LIKE '%Plumrocket_Faq%';";
		}
		
		$writeConnection->query($query);
	}
}