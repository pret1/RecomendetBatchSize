<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecommendedBatchSize\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;

class TypeRowSizeEstimator
{
    /**
     * @param $rowSizeEstimator
     * @return void
     * @throws LocalizedException
     */
    public function checkTypeRowSizeEstimator($rowSizeEstimator): void
    {
        if(!($rowSizeEstimator instanceof IndexTableRowSizeEstimatorInterface)){
            throw new LocalizedException(
                __("%1 doesn't extend Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface", get_class($rowSizeEstimator))
            );
        }
    }
}
