<?php

namespace App\Application;

use App\Domain\Product;

final class ProductResponse
{
    public function product(Product $product): array
    {
        return ['uuid' => $product->uuid(), 'name' => $product->name(), 'price' => $product->price(), 'quantity' => $product->quantity()];
    }
}
