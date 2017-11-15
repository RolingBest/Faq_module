<?php

class Plumrocket_Faq_Model_Mysql4_Faq extends Mage_Core_Model_Mysql4_Abstract {
	
	protected function _construct() 
	{
		$this->_init('plumrocket_faq/faq', 'faq_id');
	}
	
	protected function _getLoadSelect($field, $value, $object) {
		$select = parent::_getLoadSelect($field, $value, $object);
		
		if ($object->getStoreId()) {
			$select->join(
				array('nns' => $this->getTable('plumrocket_faq/faq_store')),
				$this->getMainTable() . '.item_id = `nns`.faq_id'
			)->where('is_active=1 AND `nns`.store_id in (0, ?) ',
			$object->getStoreId())->order('creation_time DESC')->limit(1);
		}
		
		return $select;
	}
	
	
	protected function _beforeSave(Mage_Core_Model_Abstract $object) {
		if (!$object->getId()) {
			$object->setCreationTime(Mage :: getSingleton('core/date')->gmtDate());
		}
		
		$object->setPublicationTime(
			Mage::app()->getLocale()->date($object->getPublicationTime(),
			Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
			null, false)->toString(Varien_Date::DATETIME_INTERNAL_FORMAT)
		);
		
		$object->setUpdateTime(Mage :: getSingleton('core/date')->gmtDate());
	}
	
	protected function _afterSave(Mage_Core_Model_Abstract $object)
	{
		$condition = $this->_getWriteAdapter()->quoteInto('faq_id = ?', $object->getId());
		
		
		$this->_getWriteAdapter()->delete($this->getTable('plumrocket_faq/faq_store'), $condition);
		foreach ((array) $object->getData('stores') as $store) {
			$storeArray = array ();
			$storeArray['faq_id'] = $object->getId();
			$storeArray['store_id'] = $store;
			$this->_getWriteAdapter()->insert(
				$this->getTable('plumrocket_faq/faq_store'), $storeArray
			);
		}
		
		
        $this->_getWriteAdapter()->delete($this->getTable('plumrocket_faq/category_item'), $condition);
        foreach ((array) $object->getData('categories') as $categoryId) {
            $categoryArray = array ();
            $categoryArray['faq_id'] = $object->getId();
            $categoryArray['category_id'] = $categoryId;
            $this->_getWriteAdapter()->insert(
                $this->getTable('plumrocket_faq/category_item'), $categoryArray
            );
        }
		
		return parent::_afterSave($object);
	}
	
	protected function _afterLoad(Mage_Core_Model_Abstract $object)
	{
	    
		$select = $this->_getReadAdapter()->select()->from(
			$this->getTable('plumrocket_faq/faq_store')
		)->where('faq_id = ?', $object->getId());
		
		if ($data = $this->_getReadAdapter()->fetchAll($select)) {
			$storesArray = array ();
			foreach ($data as $row) {
				$storesArray[] = $row['store_id'];
			}
			$object->setData('store_id', $storesArray);
		}
		
		
        $select = $this->_getReadAdapter()->select()->from(
            $this->getTable('plumrocket_faq/category_item')
        )->where('faq_id = ?', $object->getId());
        
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $categoryArray = array ();
            foreach ($data as $row) {
                $categoryArray[] = $row['category_id'];
            }
            $object->setData('category_id', $categoryArray);
        }
        
		return parent::_afterLoad($object);
	}
}