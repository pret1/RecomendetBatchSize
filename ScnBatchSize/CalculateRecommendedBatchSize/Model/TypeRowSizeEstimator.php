<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecommendedBatchSize\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;

class TypeRowSizeEstimator
{
    public function checkTypeRowSizeEstimator($rowSizeEstimator)
    {
        if(!($rowSizeEstimator instanceof IndexTableRowSizeEstimatorInterface)){
            throw new LocalizedException(
                __("%1 doesn't extends Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface", get_class($rowSizeEstimator))
            );
        }
    }
}
