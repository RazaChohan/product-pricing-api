<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\PriceData;

interface ApiMapperInterface
{
    /**
     * @return array<PriceData>
     */
    public function map(array $data): array;
}