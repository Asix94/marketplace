<?php

namespace App\Application;

use App\Domain\Product;
use App\Domain\Products;

use function Lambdish\Phunctional\map;

final class ProductsResponse
{
    public function products(Products $products): array
    {
        return map(function (Product $product) {
            return ["uuid" => $product->uuid(), "name" => $product->name(), "price" => $product->price()];
        }, $products->items());
    }
}
