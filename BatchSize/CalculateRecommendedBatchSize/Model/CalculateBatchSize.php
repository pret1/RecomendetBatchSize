<?php

declare(strict_types=1);

namespace BatchSize\CalculateRecommendedBatchSize\Model;

use Magento\Framework\App\ResourceConnection;
use BatchSize\CalculateRecommendedBatchSize\Model\RowSizeEstimatorPool;

class CalculateBatchSize
{
    /**
     * @param ResourceConnection $resourceConnection
     * @param RowSizeEstimatorPool $rowSizeEstimatorPool
     */
    public function __construct(
        private readonly ResourceConnection $resourceConnection,
        private readonly RowSizeEstimatorPool $rowSizeEstimatorPool,
    ) {
    }

    /**
     * @param $coefficient
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(float $coefficient): void
    {
        $connection = $this->resourceConnection->getConnection();

        foreach ($this->rowSizeEstimatorPool->get() as $nameIndex => $rowSizeEstimator) {
            $rowMemory = $rowSizeEstimator->estimateRowSize();
            $bufferPoolSize = $connection->fetchOne('SELECT @@innodb_buffer_pool_size;');
            $batchSize = ceil((($bufferPoolSize * 0.2) / $rowMemory) * $coefficient);
            echo sprintf(
                "Recommended batchSize=%s for index %s \n",
                $batchSize,
                $nameIndex
            );
        }
    }
}
