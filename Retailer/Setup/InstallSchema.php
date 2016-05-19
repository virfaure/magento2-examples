<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Training\Retailer\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /** @var SchemaSetupInterface */
    private $setup;

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->setup = $setup;
        $this->setup->startSetup();

        /**
         * Create table 'training_retailer_entity'
         */
        $retailerTable = $this->createRetailerTable();
        $this->setup->getConnection()->createTable($retailerTable);

        /**
         * Create table 'training_retailer_store'
         */
        $retailerWebsiteTable = $this->createRetailerWebsiteTable();
        $this->setup->getConnection()->createTable($retailerWebsiteTable);

        $this->setup->endSetup();
    }

    /**
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function createRetailerTable()
    {
        return $this->setup->getConnection()->newTable(
            $this->getRetailerTable()
        )->addColumn(
            'retailer_id',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'identity' => true, 'primary' => true],
            'Retailer Id'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Name'
        )->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Name'
        )->addColumn(
            'comment',
            Table::TYPE_TEXT,
            '1k',
            ['nullable' => false, 'default' => ''],
            'Name'
        )->addColumn(
            'is_enabled',
            Table::TYPE_SMALLINT,
            1,
            ['unsigned' => true, 'nullable' => false, 'default' => 1],
            'Name'
        )->addColumn(
            'created_at',
            Table::TYPE_DATETIME,
            'Created At'
        )->addColumn(
            'modified_at',
            Table::TYPE_DATETIME,
            'Modified At'
        )->addIndex(
            $this->setup->getIdxName(
                $this->getRetailerTable(),
                ['name'],
                AdapterInterface::INDEX_TYPE_INDEX
            ),
            ['name'],
            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
        )->addIndex(
            $this->setup->getIdxName(
                $this->getRetailerTable(),
                ['email'],
                AdapterInterface::INDEX_TYPE_INDEX
            ),
            ['email'],
            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
        );
    }

    /**
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function createRetailerWebsiteTable()
    {
        return $this->setup->getConnection()->newTable(
            $this->getRetailerStoreTable()
        )->addColumn(
            'retailer_id',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Retailer Id'
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'auto_increment' => false],
            'Store Id'
        )->addForeignKey(
            $this->setup->getFkName(
                $this->getRetailerStoreTable(),
                'retailer_id',
                $this->getRetailerTable(),
                'retailer_id'
            ),
            'retailer_id',
            $this->getRetailerTable(),
            'retailer_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $this->setup->getFkName(
                $this->getRetailerStoreTable(),
                'store_id',
                $this->setup->getTable('store'),
                'store_id'
            ),
            'store_id',
            $this->setup->getTable('store'),
            'store_id',
            Table::ACTION_CASCADE
        );
    }

    /**
     * @return string
     */
    private function getRetailerTable()
    {
        return $this->setup->getTable('training_retailer_entity');
    }

    /**
     * @return string
     */
    private function getRetailerStoreTable()
    {
        return $this->setup->getTable('training_retailer_store');
    }
}
