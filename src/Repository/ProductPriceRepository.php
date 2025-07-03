<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductPrice;
use App\Dto\PriceData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductPrice::class);
    }

    public function findLowestPriceByProductId(string $productId): ?ProductPrice
    {
        return $this->findOneBy(['productId' => $productId]) ?? null;
    }

    public function storeLowestPrice(PriceData $priceData): void
    {
        $productId = $priceData->productId;
        $existingPrice = $this->findLowestPriceByProductId($productId);

        if (!$existingPrice || $priceData->price < $existingPrice->getPrice()) {
            $newPrice = $existingPrice
                ? (clone $existingPrice)
                    ->withVendor($priceData->vendor)
                    ->withPrice($priceData->price)
                    ->withFetchedAt($priceData->fetchedAt)
                : (new ProductPrice())->withProductId($productId)
                    ->withVendor($priceData->vendor)
                    ->withPrice($priceData->price)
                    ->withFetchedAt($priceData->fetchedAt);

            $this->getEntityManager()->persist($newPrice);
            $this->getEntityManager()->flush();
        }
    }
}