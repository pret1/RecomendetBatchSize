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
use Magento\Catalog\Model\Indexer\Category\Product\RowSizeEstimator;
use Magento\Catalog\Model\ResourceModel\Product\Indexer\Eav\SourceRowSizeEstimator;
use Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\IndexTableRowSizeEstimator;

//use ScnBatchSize\CalculateRecommendedBatchSize\Model\CalculateBatchSize;
use Magento\Framework\App\ResourceConnection;

class CommandCalculateBatchSize extends Command
{
    //    private const INDEX_NAME = 'index:name';
    public const COMMAND_NAME = 'calculate:batch:size';

    private ResourceConnection $resourceConnection;

    public function __construct(
        private readonly IndexTableRowSizeEstimatorInterface $rowSizeEstimator6,
        private readonly RowSizeEstimator $rowSizeEstimator1,
        private readonly SourceRowSizeEstimator $rowSizeEstimator3,
        private readonly IndexTableRowSizeEstimator $rowSizeEstimator5,
        //        private readonly CalculateBatchSize $connectionForCalculateBatchSize,
        ResourceConnection $resourceConnection,
        string $name = null,
    ) {
        parent::__construct($name);
        $this->resourceConnection = $resourceConnection;
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Calculate recommended BatchSize for index.');
        //        $this->setDefinition($this->getInputList());
        //        $this->addOption(
        //            self::INDEX_NAME,
        //            null,
        //            InputOption::VALUE_REQUIRED,
        //            'Index'
        //        );

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
        $arrayIndexes = [
            //            "catalogrule_product" => ,
            //            "catalogrule_rule"=> ,
            //            "catalogsearch_fulltext"=> ,
            "catalog_category_product"  => $this->rowSizeEstimator1,
            //            "customer_grid"=> ,
            //            "design_config_grid"=> ,
            //            "inventory"=> ,
            "catalog_product_category"  => $this->rowSizeEstimator1,
            "catalog_product_attribute" => $this->rowSizeEstimator3,
            "catalog_product_price"     => $this->rowSizeEstimator5,
            "cataloginventory_stock"    => $this->rowSizeEstimator6,
        ];

        foreach ($arrayIndexes as $nameIndex => $rowSizeEstimator) {
            $rowMemory = $rowSizeEstimator->estimateRowSize();
            $bufferPoolSize = $connection->fetchOne('SELECT @@innodb_buffer_pool_size;');
            $batchSize = ceil((($bufferPoolSize * 0.2) / $rowMemory) * 0.95);
            echo sprintf(
                "Command %s work, recommended batchSize=%s for index %s \n",
                self::COMMAND_NAME,
                $batchSize,
                $nameIndex
            );
//            exit();
        }
        //        $index = $this->getIndexers($input);
//        $connection = $this->resourceConnection->getConnection();
        //        magento/vendor/magento/framework/Indexer/BatchSizeManagement.php:41
        //        $a = $input;
        //        $b = $output;
//        $rowMemory = $this->rowSizeEstimator6->estimateRowSize();
//        $bufferPoolSize = $connection->fetchOne('SELECT @@innodb_buffer_pool_size;');
//        $batchSize = ceil((($bufferPoolSize * 0.2) / $rowMemory) * 0.95);

//        echo sprintf(
//            "Command %s work, recommended batchSize=%s for index ?? \n",
//            self::COMMAND_NAME,
//            $batchSize
//        );
//        exit();

        //        echo sprintf(
        //            "Command %s work, recomendet batchSize=  \n",
        //            self::COMMAND_NAME
        //        );
        //        exit();
        //        echo sprintf("Command %s work, recommended batchSize=%s for index %s  \n",
        //            self::COMMAND_NAME, self::INDEX_NAME, $batchSize);
    }
}
