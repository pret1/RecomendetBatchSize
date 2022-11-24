<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecommendedBatchSize\Model;

use Magento\Catalog\Model\Indexer\Category\Product\AbstractAction;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Config;

class CalculateBatchSize extends AbstractAction
{
    public function __construct(
        private readonly IndexTableRowSizeEstimatorInterface $rowSizeEstimator,
        private readonly AdapterInterface $connectionTwo,
        ResourceConnection $resource,
        StoreManagerInterface $storeManager,
        Config $config,
    ) {
        parent::__construct(
            $resource,
            $storeManager,
            $config,
        );
    }
    public function execute()
    {
//         $this->connection;
        $this->calculateBitchSize($this->connection);
    }

    public function calculateBitchSize(\Magento\Framework\DB\Adapter\AdapterInterface $connectionTwo)
    {
        $rowMemory = $this->rowSizeEstimator->estimateRowSize();
        $bufferPoolSize = $this->connectionTwo->fetchOne('SELECT @@innodb_buffer_pool_size;');
        //
       return $batchSize = (($bufferPoolSize * 0.2)/$rowMemory)*0.95;
    }
}
