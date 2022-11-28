<?php

declare(strict_types=1);

namespace ScnBatchSize\CalculateRecommendedBatchSize\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use ScnBatchSize\CalculateRecommendedBatchSize\Model\CalculateBatchSize;

class CommandCalculateBatchSize extends Command
{
    public const COMMAND_NAME = 'calculate:batch:size';

    /**
     * @param CalculateBatchSize $calculateBatchSize
     */
    public function __construct(
        private readonly CalculateBatchSize $calculateBatchSize
    ) {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Calculate recommended BatchSize for index.');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->calculateBatchSize->execute();
    }
}
