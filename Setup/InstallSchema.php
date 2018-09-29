<?php


namespace Shulgin\AdminLogging\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $table_shulgin_adminlogging_log = $setup->getConnection()->newTable($setup->getTable('shulgin_adminlogging_log'));

        $table_shulgin_adminlogging_log->addColumn(
            'log_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,],
            'Entity ID'
        );

        $table_shulgin_adminlogging_log->addColumn(
            'action',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'action'
        );
        
        $table_shulgin_adminlogging_log->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Log Modification Time'
        );

        $table_shulgin_adminlogging_log->addColumn(
            'before_save',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'before_save'
        );

        $table_shulgin_adminlogging_log->addColumn(
            'after_save',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'after_save'
        );

        $table_shulgin_adminlogging_log->addColumn(
            'diff',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'diff'
        );

        $table_shulgin_adminlogging_log->addColumn(
            'user',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'user'
        );

        $setup->getConnection()->createTable($table_shulgin_adminlogging_log);
    }
}
