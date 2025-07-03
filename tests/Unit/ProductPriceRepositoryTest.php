<?php

namespace App\Tests\Unit;

use App\Entity\ProductPrice;
use App\Repository\ProductPriceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class ProductPriceRepositoryTest extends TestCase
{
    private $registry;
    private $entityManager;

    protected function setUp(): void
    {
        $this->registry = $this->createMock(ManagerRegistry::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->registry->method('getManagerForClass')->willReturn($this->entityManager);
    }

    public function testFindLowestPriceByProductIdFound(): void
    {
        $price = (new ProductPrice())->withProductId('123')
            ->withVendor('ShopB')
            ->withPrice(17.49)
            ->withFetchedAt(new \DateTimeImmutable('2025-06-17T14:00:00Z'));

        $this->entityManager->method('createQueryBuilder')->willReturnSelf();
        $this->entityManager->method('from')->willReturnSelf();
        $this->entityManager->method('where')->willReturnSelf();
        $this->entityManager->method('setParameter')->willReturnSelf();
        $this->entityManager->method('getQuery')->willReturnSelf();
        $this->entityManager->method('getOneOrNullResult')->willReturn($price);

        $repository = new ProductPriceRepository($this->registry);
        $result = $repository->findLowestPriceByProductId('123');

        $this->assertSame($price, $result);
    }

    public function testFindLowestPriceByProductIdNotFound(): void
    {
        $this->entityManager->method('createQueryBuilder')->willReturnSelf();
        $this->entityManager->method('from')->willReturnSelf();
        $this->entityManager->method('where')->willReturnSelf();
        $this->entityManager->method('setParameter')->willReturnSelf();
        $this->entityManager->method('getQuery')->willReturnSelf();
        $this->entityManager->method('getOneOrNullResult')->willReturn(null);

        $repository = new ProductPriceRepository($this->registry);
        $result = $repository->findLowestPriceByProductId('123');

        $this->assertNull($result);
    }
}
