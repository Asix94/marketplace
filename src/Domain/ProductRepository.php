<?php

namespace App\Domain;

interface ProductRepository
{
    public function create(Product $product): string;

    public function findById(string $uuid): Product;
}
