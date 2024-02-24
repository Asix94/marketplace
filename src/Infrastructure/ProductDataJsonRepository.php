<?php

namespace App\Infrastructure;

use App\Application\ProductResponse;
use App\Domain\Product;
use App\Domain\ProductRepository;

final class ProductDataJsonRepository implements ProductRepository
{
    public function __construct(private readonly ProductResponse $productResponse) {}
    public function create(Product $product): string
    {
        $jsonFile = file_get_contents('products.json');
        $products = json_decode($jsonFile, true);
        $products[] = $this->productResponse->product($product);
        $updateJsonFile = json_encode($products, JSON_PRETTY_PRINT);
        file_put_contents('products.json', $updateJsonFile);
        return $product->uuid();
    }

    public function findById(string $uuid): Product
    {
        $jsonFile = file_get_contents('products.json');
        $products = json_decode($jsonFile, true);
        $productSelect = null;
        foreach ($products as $product) {
            if ($product['uuid'] === $uuid) {
                $productSelect = $product;
                break;
            }
        }

        return new Product(
            $productSelect['uuid'],
            $productSelect['name'],
            $productSelect['price'],
            $productSelect['quantity']
        );
    }
}
