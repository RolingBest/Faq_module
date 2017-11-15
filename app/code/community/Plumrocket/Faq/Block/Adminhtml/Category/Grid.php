<?php

class Plumrocket_Faq_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $collection = Mage::getResourceModel('plumrocket_faq/category_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('category_id', array (
                'header' => Mage::helper('plumrocket_faq')->__('Category #'), 
                'width' => '80px', 
                'type' => 'text', 
                'index' => 'category_id' ));
        
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
        
        $this->addColumn(
            'category_name',
            array(
                'header' => Mage::helper('plumrocket_faq')->__('Category Name'), 
                'index' => 'category_name',
            )
        );
        
        $this->addColumn('is_active', 
                array (
                        'header' => Mage::helper('cms')->__('Active'), 
                        'index' => 'is_active', 
                        'type' => 'options', 
                        'width' => '70px', 
                        'options' => array (
                                0 => Mage::helper('cms')->__('No'), 
                                1 => Mage::helper('cms')->__('Yes') ) ));
        
        $this->addColumn(
            'action', 
            array (
                    'header' => Mage::helper('plumrocket_faq')->__('Action'), 
                    'width' => '50px',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array (
                        array (
                            'caption' => Mage::helper('plumrocket_faq')->__('Edit'), 
                            'url' => array (
                                'base' => '*/*/edit'
                            ), 
                            'field' => 'category_id'
                        ),
                    ),
                    'filter' => false, 
                    'sortable' => false, 
                    'index' => 'stores', 
                    'is_system' => true,
            )
        );
        
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
        return $this->getUrl('*/*/edit', array (
                'category_id' => $row->getCategoryId() ));
    }

    public function getGridUrl()
    {
        return $this->getUrl(
            '*/*/',
            array (
                '_current' => true,
            )
        );
    }
}