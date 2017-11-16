<?php

class Plumrocket_Faq_Model_Resource_Faqs extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('plumrocketfaq/table_faq', 'faqs_id');
    }

}