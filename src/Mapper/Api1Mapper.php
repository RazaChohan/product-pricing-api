<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\PriceData;
use DateTimeImmutable;

class Api1Mapper implements ApiMapperInterface
{
    /**
     * @return array<PriceData>
     */
    public function map(array $data): array
    {
        $productId = $data['product_id'] ?? '';
        $prices = $data['prices'] ?? [];

        if (empty($productId) || empty($prices)) {
            return [];
        }

        return array_map(
            fn(array $item): PriceData => new PriceData(
                productId: $productId,
                vendor: $item['vendor'],
                price: (float) $item['price'],
                fetchedAt: new DateTimeImmutable()
            ),
            $prices
        );
    }
}