<?php

declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;

readonly class PriceData
{
    public function __construct(
        public string             $productId,
        public string             $vendor,
        public float              $price,
        public DateTimeImmutable $fetchedAt
    )
    {
    }
}