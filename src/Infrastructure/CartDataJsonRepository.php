<?php

namespace App\Infrastructure;

use App\Application\ProductResponse;
use App\Domain\Product;
use App\Domain\Products;
use App\Domain\ShopCart;
use App\Domain\CartRepository;
use Ramsey\Uuid\Uuid;

use function Lambdish\Phunctional\map;

final class CartDataJsonRepository implements CartRepository
{
    public function __construct(private readonly ProductResponse $productResponse) {}
    public function cartCreate(): string
    {
        $jsonFile = file_get_contents('carts.json');
        $carts = json_decode($jsonFile, true);
        $uuid = Uuid::uuid4()->toString();
        $carts[] = ['uuid' => $uuid, 'products' => [], 'price' => 0];
        $updateJsonFile = json_encode($carts, JSON_PRETTY_PRINT);
        file_put_contents('carts.json', $updateJsonFile);
        return $uuid;
    }
    public function addToCart(Product $product, string $uuid): void
    {
        $jsonFile = file_get_contents('carts.json');
        $carts = json_decode($jsonFile, true);
        foreach ($carts as &$cart) {
            if ($cart['uuid'] === $uuid) {
                $exist = false;
                foreach ($cart['products'] as &$productCart) {
                    if ($productCart['uuid'] === $product->uuid()) {
                        $exist = true;
                        $productCart['quantity'] += 1;
                    }
                }
                if (!$exist) {
                    $cart['products'][] = $this->productResponse->product($product);
                }
                $cart['price'] += $product->price();
            }
        }
        $updateJsonFile = json_encode($carts, JSON_PRETTY_PRINT);
        file_put_contents('carts.json', $updateJsonFile);
    }

    public function deleteToCart(Product $product, string $uuid): void
    {
        $jsonFile = file_get_contents('carts.json');
        $carts = json_decode($jsonFile, true);
        foreach ($carts as $cartKey => &$cart) {
            if ($cart['uuid'] === $uuid) {
                foreach ($cart['products'] as $key => &$productCart) {
                    if ($productCart['uuid'] === $product->uuid()) {
                        $productCart['quantity'] -= 1;
                        if ($productCart['quantity'] <= 0) {
                            unset($carts[$cartKey]['products'][$key]);
                        }
                    }
                }
                $cart['price'] -= $product->price();
            }
        }
        $updateJsonFile = json_encode($carts, JSON_PRETTY_PRINT);
        file_put_contents('carts.json', $updateJsonFile);
    }

    public function pay(string $uuid): void
    {
        $jsonFile = file_get_contents('carts.json');
        $carts = json_decode($jsonFile, true);

        foreach ($carts as $key => &$cart) {
            if ($cart['uuid'] === $uuid) {
                unset($carts[$key]);
            }
        }

        $updateJsonFile = json_encode($carts, JSON_PRETTY_PRINT);
        file_put_contents('carts.json', $updateJsonFile);
    }

    public function findbyId(string $uuid): ?ShopCart
    {
        $jsonFile = file_get_contents('carts.json');
        $carts = json_decode($jsonFile, true);
        $cartSelect = null;
        foreach ($carts as $cart) {
            if ($cart['uuid'] === $uuid) {
                $cartSelect = $cart;
                break;
            }
        }

        if ($cartSelect) {
            return new ShopCart(
                $cartSelect['uuid'],
                Products::create(
                    map(function (array $product) {
                        return new Product(
                            $product['uuid'],
                            $product['name'],
                            $product['price'],
                            $product['quantity']);
                    }, $cartSelect['products'])
                ),
                $cartSelect['price']
            );
        }

        return null;
    }
}
