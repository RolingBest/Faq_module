<?php

class Plumrocket_Faq_Model_Mysql4_Category extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
        $this->_init('plumrocket_faq/category', 'category_id');
    }
   
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        
        if ($object->getStoreId()) {
            $select->join(
                array('nns' => $this->getTable('plumrocket_faq/category_store')),
                $this->getMainTable() . '.item_id = `nns`.category_id'
            )->where('is_active=1 AND `nns`.store_id in (0, ?) ',
            $object->getStoreId())->order('creation_time DESC')->limit(1);
        }
        return $select;
    }
    
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getId()) {
            $object->setCreationTime(Mage::getSingleton('core/date')->gmtDate());
        }
        $object->setUpdateTime(Mage::getSingleton('core/date')->gmtDate());
        
        return parent::_beforeSave($object);
    }
  
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $condition = $this->_getWriteAdapter()->quoteInto('category_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('plumrocket_faq/category_store'), $condition);
        
        foreach ((array) $object->getData('stores') as $store) {
            $storeArray = array ();
            $storeArray['category_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert(
                $this->getTable('plumrocket_faq/category_store'), $storeArray
            );
        }
        
        return parent::_afterSave($object);
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getReadAdapter()->select()->from(
            $this->getTable('plumrocket_faq/category_store')
        )->where('category_id = ?', $object->getId());
        
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array ();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }
        
        return parent::_afterLoad($object);
    }
}