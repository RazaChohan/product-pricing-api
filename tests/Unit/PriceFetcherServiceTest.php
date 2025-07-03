<?php

namespace App\Tests\Unit;

use App\Repository\ProductPriceRepository;
use App\Mapper\Api1Mapper;
use App\Mapper\Api2Mapper;
use App\Service\MockApiService;
use App\Dto\PriceData;
use App\Service\PriceFetcherService;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class PriceFetcherServiceTest extends TestCase
{
    private $mockApiService;
    private $productPriceRepository;
    private $logger;
    private $mappers;

    protected function setUp(): void
    {
        $this->mockApiService = $this->createMock(MockApiService::class);
        $this->productPriceRepository = $this->createMock(ProductPriceRepository::class);
        $this->logger = $this->createMock(Logger::class);
        $this->mappers = [
            'api1' => new Api1Mapper(),
            'api2' => new Api2Mapper(),
        ];
    }

    public function testFetchAndStorePricesWithNewPrice(): void
    {
        $this->mockApiService->method('fetchApi1')->willReturn([
            'product_id' => '123',
            'prices' => [
                ['vendor' => 'ShopA', 'price' => 19.99],
                ['vendor' => 'ShopB', 'price' => 17.49],
            ],
        ]);
        $this->mockApiService->method('fetchApi2')->willReturn([
            'id' => '123',
            'competitor_data' => [
                ['name' => 'VendorOne', 'amount' => 20.49],
                ['name' => 'VendorTwo', 'amount' => 18.99],
            ],
        ]);

        $this->productPriceRepository->expects($this->exactly(4))
            ->method('storeLowestPrice')
            ->with($this->isInstanceOf(PriceData::class));
        $this->logger->expects($this->exactly(4))
            ->method('info')
            ->with($this->stringContains('Stored price for product 123'));

        $service = new PriceFetcherService($this->mockApiService, $this->productPriceRepository, $this->logger, $this->mappers);
        $service->fetchAndStorePrices();
    }

    public function testFetchAndStorePricesWithLowerPrice(): void
    {
        $this->mockApiService->method('fetchApi1')->willReturn([]);
        $this->mockApiService->method('fetchApi2')->willReturn([
            'id' => '123',
            'competitor_data' => [
                ['name' => 'VendorTwo', 'amount' => 18.99],
            ],
        ]);

        $this->productPriceRepository->expects($this->once())
            ->method('storeLowestPrice')
            ->with($this->isInstanceOf(PriceData::class));
        $this->logger->expects($this->once())
            ->method('info')
            ->with('Stored price for product 123: 18.99 from VendorTwo');

        $service = new PriceFetcherService($this->mockApiService, $this->productPriceRepository, $this->logger, $this->mappers);
        $service->fetchAndStorePrices();
    }

    public function testFetchAndStorePricesWithHigherPrice(): void
    {
        $this->mockApiService->method('fetchApi1')->willReturn([
            'product_id' => '123',
            'prices' => [
                ['vendor' => 'ShopA', 'price' => 19.99],
            ],
        ]);
        $this->mockApiService->method('fetchApi2')->willReturn([]);

        $this->productPriceRepository->expects($this->once())
            ->method('storeLowestPrice')
            ->with($this->isInstanceOf(PriceData::class));

        $service = new PriceFetcherService($this->mockApiService, $this->productPriceRepository, $this->logger, $this->mappers);
        $service->fetchAndStorePrices();
    }
}
