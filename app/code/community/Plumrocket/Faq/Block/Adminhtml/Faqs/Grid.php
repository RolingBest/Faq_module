<?php

class Plumrocket_Faq_Block_Adminhtml_Faqs_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('plumrocketfaq/faqs')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('plumrocketfaq');

        $this->addColumn('faqs_id', array(
            'header' => $helper->__('Faqs ID'),
            'index' => 'faqs_id'
        ));

        $this->addColumn('title', array(
            'header' => $helper->__('Title'),
            'index' => 'title',
            'type' => 'text',
        ));

        $this->addColumn('is_active', array(
            'header' => $helper->__('is_active'),
            'index' => 'is_active',
            'type' => 'boolean',
        ));

        return parent::_prepareColumns();
    }

	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('faqs_id');
        $this->getMassactionBlock()->setFormFieldName('faqs');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }
	 public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
                    'id' => $model->getId(),
                ));
    }

}