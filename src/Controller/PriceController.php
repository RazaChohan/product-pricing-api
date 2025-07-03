<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProductPriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Psr\Log\LoggerInterface;

class PriceController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface                $logger,
        private readonly ProductPriceRepository $productPriceRepository
    )
    {
    }

    #[Route('/api/prices/{id}', name: 'get_price', methods: ['GET'])]
    public function getPrice(string $id, Request $request): JsonResponse
    {
        $price = $this->productPriceRepository->findLowestPriceByProductId($id);

        if (!$price) {
            $this->logger->warning("Price not found for product ID: $id");
            return new JsonResponse(['error' => 'Price not found'], 404);
        }

        $this->logger->info("Fetched price for product ID: $id");
        return new JsonResponse([
            'product_id' => $price->getProductId(),
            'vendor' => $price->getVendor(),
            'price' => $price->getPrice(),
            'fetched_at' => $price->getFetchedAt()->format('c'),
        ]);
    }
}
