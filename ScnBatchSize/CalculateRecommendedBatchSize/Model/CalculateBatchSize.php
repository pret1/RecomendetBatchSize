<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecommendedBatchSize\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;
use ScnBatchSize\CalculateRecommendedBatchSize\Model\TypeRowSizeEstimator;

class CalculateBatchSize
{
    /**
     * @param ResourceConnection $resourceConnection
     * @param array $rowSizeEstimatorPool
     */
    public function __construct(
        private readonly ResourceConnection $resourceConnection,
        private readonly TypeRowSizeEstimator $typeRowSizeEstimator,
        private readonly array $rowSizeEstimatorPool = [],
    ) {
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $connection = $this->resourceConnection->getConnection();

        foreach ($this->rowSizeEstimatorPool as $nameIndex => $rowSizeEstimator) {
            $this->typeRowSizeEstimator->checkTypeRowSizeEstimator($rowSizeEstimator);
//            if(!($rowSizeEstimator instanceof IndexTableRowSizeEstimatorInterface)){
//                throw new LocalizedException(
//                    __("%1 doesn't extends Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface", get_class($rowSizeEstimator))
//                );
//            }
            $rowMemory = $rowSizeEstimator->estimateRowSize();
            $bufferPoolSize = $connection->fetchOne('SELECT @@innodb_buffer_pool_size;');
            $batchSize = ceil((($bufferPoolSize * 0.2) / $rowMemory) * 0.95);
            echo sprintf(
                "Recommended batchSize=%s for index %s \n",
                $batchSize,
                $nameIndex
            );
        }
    }
}
