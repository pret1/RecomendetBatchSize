<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecommendedBatchSize\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
//use \Magento\Indexer\Console\Command\AbstractIndexerManageCommand;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;
//use Magento\Catalog\Model\Indexer\Category\Product\RowSizeEstimator;
//use Magento\Catalog\Model\ResourceModel\Product\Indexer\Eav\SourceRowSizeEstimator;
//use Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\IndexTableRowSizeEstimator;
//use ScnBatchSize\CalculateRecommendedBatchSize\Model\CalculateBatchSize;
use Magento\Framework\App\ResourceConnection;

class CommandCalculateBatchSize extends Command
{
    public const COMMAND_NAME = 'calculate:batch:size';

    private ResourceConnection $resourceConnection;

    /**
     * @var IndexTableRowSizeEstimatorInterface[]
     */
    private array $rowSizeEstimatorPool;

    public function __construct(
//        private readonly IndexTableRowSizeEstimatorInterface $rowSizeEstimator6,
//        private readonly IndexTableRowSizeEstimatorInterface $rowSizeEstimator1,
//        private readonly IndexTableRowSizeEstimatorInterface $rowSizeEstimator3,
//        private readonly IndexTableRowSizeEstimatorInterface $rowSizeEstimator5,
        //        private readonly CalculateBatchSize $connectionForCalculateBatchSize,
        ResourceConnection $resourceConnection,
        array $rowSizeEstimatorPool = [],
        string $name = null,
    ) {
        parent::__construct($name);
        $this->resourceConnection = $resourceConnection;
        $this->rowSizeEstimatorPool = $rowSizeEstimatorPool;
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Calculate recommended BatchSize for index.');

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->resourceConnection->getConnection();
//        $arrayIndexes = [
//            "catalog_category_product"  => $this->rowSizeEstimator1,
//            "catalog_product_category"  => $this->rowSizeEstimator1,
//            "catalog_product_attribute" => $this->rowSizeEstimator3,
//            "catalog_product_price"     => $this->rowSizeEstimator5,
//            "cataloginventory_stock"    => $this->rowSizeEstimator6,
//        ];

        foreach ($this->rowSizeEstimatorPool as $nameIndex => $rowSizeEstimator) {
            $rowMemory = $rowSizeEstimator->estimateRowSize();
            $bufferPoolSize = $connection->fetchOne('SELECT @@innodb_buffer_pool_size;');
            $batchSize = ceil((($bufferPoolSize * 0.2) / $rowMemory) * 0.95);
            echo sprintf(
                "Command %s work, recommended batchSize=%s for index %s \n",
                self::COMMAND_NAME,
                $batchSize,
                $nameIndex
            );
        }
    }
}
