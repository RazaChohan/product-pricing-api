<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;

class MockApiService
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function fetchApi1(): array
    {
        $this->logger->info('Fetching data from Mock API 1');
        $data = json_decode(file_get_contents(__DIR__ . '/../../data/api1.json'), true);
        return $data ?: [];
    }

    public function fetchApi2(): array
    {
        $this->logger->info('Fetching data from Mock API 2');
        $data = json_decode(file_get_contents(__DIR__ . '/../../data/api2.json'), true);
        return $data ?: [];
    }
}
