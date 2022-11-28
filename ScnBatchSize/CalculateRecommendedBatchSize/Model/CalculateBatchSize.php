<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecommendedBatchSize\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;
use ScnBatchSize\CalculateRecommendedBatchSize\Model\TypeRowSizeEstimator;

class CalculateBatchSize
{
    /**
     * @param ResourceConnection $resourceConnection
     * @param TypeRowSizeEstimator $typeRowSizeEstimator
     * @param array $rowSizeEstimatorPool
     */
    public function __construct(
        private readonly ResourceConnection $resourceConnection,
        private readonly TypeRowSizeEstimator $typeRowSizeEstimator,
        private readonly array $rowSizeEstimatorPool = [],
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

        foreach ($this->rowSizeEstimatorPool as $nameIndex => $rowSizeEstimator) {
            $this->typeRowSizeEstimator->checkTypeRowSizeEstimator($rowSizeEstimator);
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
