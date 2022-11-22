<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecomendetBatchSize\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;

class CommandCalculateBatchSize extends Command
{
//    private const INDEX_NAME = 'index:name';
    public const COMMAND_NAME = 'calculate:batch:size';

//    /**
//     * @var \Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface
//     */
//    private $rowSizeEstimator;

//    /**
//     * CompositeProductBatchSizeCalculator constructor.
//     * @param \Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface $rowSizeEstimator
//     */
//    public function __construct(
//        \Magento\Framework\Indexer\IndexTableRowSizeEstimatorInterface $rowSizeEstimator,
//    ) {
//        $this->rowSizeEstimator = $rowSizeEstimator;
//        parent::__construct();
//    }

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
//        $rowMemory = $this->rowSizeEstimator->estimateRowSize();
//        /**@var \Magento\Framework\DB\Adapter\AdapterInterface $connection */
//        $bufferPoolSize = $connection->fetchOne('SELECT @@innodb_buffer_pool_size;');
//
//        $batchSize = (($bufferPoolSize * 0.2)/$rowMemory)*0.95;
//
//        echo sprintf("Command %s work, recommended batchSize=%s for index %s  \n",
//            self::COMMAND_NAME, self::INDEX_NAME, $batchSize);
//        exit();

        echo sprintf("Command %s work, recomendet batchSize=  \n",
            self::COMMAND_NAME);
        exit();
    }
}
