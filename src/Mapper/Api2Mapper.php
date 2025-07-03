<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\PriceData;
use DateTimeImmutable;

class Api2Mapper implements ApiMapperInterface
{
    /**
     * @return array<PriceData>
     */
    public function map(array $data): array
    {
        $productId = $data['id'] ?? '';
        $competitorData = $data['competitor_data'] ?? [];

        if (empty($productId) || empty($competitorData)) {
            return [];
        }

        return array_map(
            fn(array $item): PriceData => new PriceData(
                productId: $productId,
                vendor: $item['name'],
                price: (float) $item['amount'],
                fetchedAt: new DateTimeImmutable()
            ),
            $competitorData
        );
    }
}