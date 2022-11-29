<?php

declare(strict_types=1);

namespace BatchSize\CalculateRecommendedBatchSize\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;

class RowSizeEstimatorPool
{
    /**
     * @param IndexTableRowSizeEstimatorInterface[] $rowSizeEstimatorPool
     */
    public function __construct(
        private readonly array $rowSizeEstimatorPool = [],
    ) {
    }

    /**
     * @return IndexTableRowSizeEstimatorInterface[]
     * @throws LocalizedException
     */
    public function get(): array
    {
        foreach ($this->rowSizeEstimatorPool as $rowSizeEstimator) {
            if (!($rowSizeEstimator instanceof IndexTableRowSizeEstimatorInterface)) {
                throw new LocalizedException(
                    __(
                        "%1 doesn't extend Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface",
                        get_class($rowSizeEstimator)
                    )
                );
            }
        }

        return $this->rowSizeEstimatorPool;
    }
}
