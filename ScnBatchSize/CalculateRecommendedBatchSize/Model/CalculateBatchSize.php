<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecommendedBatchSize\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;

class CalculateBatchSize
{
    private ResourceConnection $resourceConnection;

    /**
     * @var IndexTableRowSizeEstimatorInterface[]
     */
    private array $rowSizeEstimatorPool;

    public function __construct(
        ResourceConnection $resourceConnection,
        array $rowSizeEstimatorPool = [],
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->rowSizeEstimatorPool = $rowSizeEstimatorPool;
    }

    public function execute(): void
    {
        $connection = $this->resourceConnection->getConnection();

        foreach ($this->rowSizeEstimatorPool as $nameIndex => $rowSizeEstimator) {
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
