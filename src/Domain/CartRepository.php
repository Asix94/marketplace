<?php

namespace App\Domain;

interface CartRepository
{
    public function cartCreate(): string;
    public function addToCart(Product $product, string $uuid): void;
    public function deleteToCart(Product $product, string $uuid): void;
    public function pay(string $uuid): void;
    public function findbyId(string $uuid): ?ShopCart;
}
