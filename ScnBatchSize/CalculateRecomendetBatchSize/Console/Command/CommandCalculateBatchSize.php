<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecomendetBatchSize\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface;

class CommandCalculateBatchSize extends Command
{
//    private const INDEX_NAME = 'index:name';
    public const COMMAND_NAME = 'calculate:batch:size';

    public function __construct(
         private readonly IndexTableRowSizeEstimatorInterface $rowSizeEstimator,
         private readonly AdapterInterface $connection,
         string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Calculate recommended BatchSize for index.');
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
//        magento/vendor/magento/framework/Indexer/BatchSizeManagement.php:41
//        $a = $input;
//        $b = $output;
//
//        /** @var \Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface $rowSizeEstimator*/
        $rowMemory = $this->rowSizeEstimator->estimateRowSize();
//        /**@var \Magento\Framework\DB\Adapter\AdapterInterface $connection */
        $bufferPoolSize = $this->connection->fetchOne('SELECT @@innodb_buffer_pool_size;');

//        $batchSize = (($bufferPoolSize * 0.2)/$rowMemory)*0.95;

//        echo sprintf("Command %s work, recommended batchSize=%s for index ?? \n",
//            self::COMMAND_NAME, $batchSize);
//        exit();

        echo sprintf("Command %s work, recomendet batchSize=  \n",
            self::COMMAND_NAME);
        exit();
//        echo sprintf("Command %s work, recommended batchSize=%s for index %s  \n",
//            self::COMMAND_NAME, self::INDEX_NAME, $batchSize);
    }
}
