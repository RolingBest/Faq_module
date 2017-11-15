<?php

$installer = $this;
$tableFaqs = $installer->getTable('plumrocketfaq/table_faq');

//die($tableFaqs);

$installer->startSetup();

$installer->getConnection()->dropTable($tableFaqs);
$table = $installer->getConnection()
    ->newTable($tableFaqs)
    ->addColumn('faqs_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ))
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => false,
        ))
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ))
    ->addColumn('created', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ));
$installer->getConnection()->createTable($table);

$installer->endSetup();
