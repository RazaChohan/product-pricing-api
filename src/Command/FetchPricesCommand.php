<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\PriceFetcherService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchPricesCommand extends Command
{
    protected static string $defaultName = 'app:fetch-prices';

    public function __construct(
        private readonly PriceFetcherService $priceFetcherService
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:fetch-prices')
            ->setDescription('Fetches and stores product prices from external APIs.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->priceFetcherService->fetchAndStorePrices();
        $output->writeln('Prices fetched and stored successfully.');
        return Command::SUCCESS;
    }
}
