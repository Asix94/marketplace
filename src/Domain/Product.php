<?php

namespace App\Domain;

final class Product
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly float $price,
        private readonly int $quantity
    ) {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }
}

