<?php

namespace App\Domain;

use App\Shared\Collection;

final class Products extends Collection
{
    public static function create(array $products): Products
    {
        return new self($products);
    }

    protected function type(): string
    {
        return Product::class;
    }
}
