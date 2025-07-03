<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\ApiType;
use App\Repository\ProductPriceRepository;
use Exception;
use Psr\Log\LoggerInterface;

class PriceFetcherService
{
    public function __construct(
        private readonly MockApiService $mockApiService,
        private readonly ProductPriceRepository $productPriceRepository,
        private readonly LoggerInterface $logger,
        private readonly array $mappers
    ) {
    }

    public function fetchAndStorePrices(): void
    {
        try {
            $api1Data = $this->mockApiService->fetchApi1();
            $api2Data = $this->mockApiService->fetchApi2();

            $this->processApiData($api1Data, ApiType::API1->value);
            $this->processApiData($api2Data, ApiType::API2->value);
        } catch (Exception $e) {
            $this->logger->error('Failed to fetch prices: ' . $e->getMessage());
        }
    }

    private function processApiData(array $data, string $source): void
    {
        if (!isset($this->mappers[$source])) {
            $this->logger->error("No mapper found for source: $source");
            return;
        }

        $mapper = $this->mappers[$source];
        try {
            $priceDataArray = $mapper->map($data);
            foreach ($priceDataArray as $priceData) {
                $this->productPriceRepository->storeLowestPrice($priceData);
                $this->logger->info("Stored price for product {$priceData->productId}: {$priceData->price} from {$priceData->vendor}");
            }
        } catch (Exception $e) {
            $this->logger->error("Failed to map data for source $source: " . $e->getMessage());
        }
    }
}
