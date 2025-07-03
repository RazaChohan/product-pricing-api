<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: 'product_prices')]
class ProductPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $productId;

    #[ORM\Column(type: 'string', length: 255)]
    private string $vendor;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $fetchedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function withProductId(string $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getVendor(): string
    {
        return $this->vendor;
    }

    public function withVendor(string $vendor): self
    {
        $this->vendor = $vendor;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function withPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getFetchedAt(): DateTimeImmutable
    {
        return $this->fetchedAt;
    }

    public function withFetchedAt(DateTimeImmutable $fetchedAt): self
    {
        $this->fetchedAt = $fetchedAt;
        return $this;
    }
}