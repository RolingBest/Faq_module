<?php

class Plumrocket_Faq_Model_Category extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('plumrocket_faq/category');
    }
    
    public function getName()
    {
        return $this->getCategoryName();
    }
    
    public function getItemCollection()
    {
        $collection = $this->getData('item_collection');
        if (is_null($collection)) {
            $collection = Mage::getSingleton('plumrocket_faq/faq')->getCollection()
                ->addCategoryFilter($this);
            $this->setData('item_collection', $collection);
        }
        return $collection;
    }
}