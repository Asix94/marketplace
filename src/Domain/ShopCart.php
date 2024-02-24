<?php

namespace App\Domain;

final class ShopCart
{
    public function __construct(
        private readonly string $uuid,
        private readonly Products $products,
        private readonly float $price
    ) {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function products(): Products
    {
        return $this->products;
    }

    public function price(): float
    {
        return $this->price;
    }
}
