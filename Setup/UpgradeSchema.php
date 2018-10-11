<?php
namespace Shulgin\AdminLogging\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;

		$installer->startSetup();

		if(version_compare($context->getVersion(), '1.0.1', '<')) {

			$installer->getConnection()->addColumn(
				$installer->getTable( 'shulgin_adminlogging_log' ),
				'resource_name',
                [
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'nullable' => true,
					'comment' => 'resource_name',
				]
            );

		}



		$installer->endSetup();
	}
}
