<?php

namespace Kobens\Gemini\Setup;

use Kobens\Gemini\Api\StrategyInterface;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * {@inheritDoc}
     * @see \Magento\Framework\Setup\UpgradeSchemaInterface::upgrade()
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $conn = $setup->getConnection();
        $conn->startSetup();
        $table = $conn
            ->newTable(StrategyInterface::MAIN_TABLE)
            ->addColumn(
                StrategyInterface::STRATEGY_ID,
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'primary' => true,
                    'unsigned' => true,
                    'nullable' => false,
                ],
                'Strategy ID'
            )
            ->addColumn(
                StrategyInterface::IS_ACTIVE,
                Table::TYPE_BOOLEAN,
                null,
                ['default' => 0, 'nullable' => false],
                'Is Active'
                )
            ->addColumn(
                StrategyInterface::TRADING_PAIR,
                Table::TYPE_TEXT,
                20,
                ['nullable' => false],
                'Trading Pair'
            )
            ->addColumn(
                StrategyInterface::STATUS,
                Table::TYPE_TEXT,
                30,
                [
                    'default' => \Kobens\Gemini\Model\Strategy\Source\Status::STATUS_BUY_PENDING,
                    'nullable' => false,
                ],
                'Status'
            )
            ->addColumn(
                StrategyInterface::OPEN_PRICE,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Open Price'
            )
            ->addColumn(
                StrategyInterface::OPEN_AMOUNT,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Open Amount'
            )
            ->addColumn(
                StrategyInterface::OPEN_ORDER_ID,
                Table::TYPE_TEXT,
                100,
                ['nullable' => true],
                'Open Order ID'
            )
            ->addColumn(
                StrategyInterface::OPEN_GEMINI_ID,
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => true],
                'Open Gemini ID'
                )
            ->addColumn(
                StrategyInterface::CLOSE_PRICE,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Close Price'
            )
            ->addColumn(
                StrategyInterface::CLOSE_AMOUNT,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Close Amount'
            )
            ->addColumn(
                StrategyInterface::CLOSE_ORDER_ID,
                Table::TYPE_TEXT,
                100,
                ['nullable' => true],
                'Close Order ID'
            )
            ->addColumn(
                StrategyInterface::CLOSE_GEMINI_ID,
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => true],
                'Close Gemini ID'
            )
            ->setComment('Maintains trading strategies')
        ;
        $conn->createTable($table);
        $conn->endSetup();
    }
}
