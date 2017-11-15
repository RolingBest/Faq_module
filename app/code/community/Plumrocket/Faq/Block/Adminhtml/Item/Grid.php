<?php

class Plumrocket_Faq_Block_Adminhtml_Item_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('faq_grid');
        $this->setUseAjax(false);
        $this->setDefaultSort('creation_time');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        //TODO: add full name logic
        $collection = Mage::getResourceModel('plumrocket_faq/faq_collection');
        $this->setCollection($collection);
        #Mage::Log($collection->getData());
        return parent::_prepareCollection();
    }
  
    protected function _prepareColumns()
    {
        $this->addColumn('faq_id', array (
                'header' => Mage::helper('plumrocket_faq')->__('FAQ #'), 
                'width' => '80px', 
                'type' => 'text', 
                'index' => 'faq_id' ));
        
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', 
                    array (
                            'header' => Mage::helper('cms')->__('Store view'), 
                            'index' => 'store_id', 
                            'type' => 'store', 
                            'store_all' => true, 
                            'store_view' => true, 
                            'sortable' => false, 
                            'filter_condition_callback' => array (
                                    $this, 
                                    '_filterStoreCondition' ) ));
        }
        
        $this->addColumn('question', array (
                'header' => Mage::helper('plumrocket_faq')->__('Question'), 
                'index' => 'question' ));
        
        $this->addColumn('is_active', 
                array (
                        'header' => Mage::helper('plumrocket_faq')->__('Active'), 
                        'index' => 'is_active', 
                        'type' => 'options', 
                        'width' => '70px', 
                        'options' => array (
                                0 => Mage::helper('plumrocket_faq')->__('No'), 
                                1 => Mage::helper('plumrocket_faq')->__('Yes') ) ));
        
        $this->addColumn('action', 
                array (
                        'header' => Mage::helper('plumrocket_faq')->__('Action'), 
                        'width' => '50px', 
                        'type' => 'action', 
                        'getter' => 'getId', 
                        'actions' => array (
                                array (
                                        'caption' => Mage::helper('plumrocket_faq')->__('Edit'), 
                                        'url' => array (
                                                'base' => 'adminhtml/faq/edit' ), 
                                        'field' => 'faq_id' ) ), 
                        'filter' => false, 
                        'sortable' => false, 
                        'index' => 'stores', 
                        'is_system' => true ));
        
        return parent::_prepareColumns();
    }
    
 
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
   
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        
        $this->getCollection()->addStoreFilter($value);
    }
    

    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/faq/edit', array (
                'faq_id' => $row->getFaqId() ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/faq/index', array (
                '_current' => true ));
    }
}