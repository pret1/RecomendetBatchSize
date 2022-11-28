<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecommendedBatchSize\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;
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
