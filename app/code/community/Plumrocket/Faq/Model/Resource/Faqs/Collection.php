<?php

class Plumrocket_Faq_Model_Resource_Faqs_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('plumrocketfaq/faqs');
    }

}