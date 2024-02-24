<?php

namespace Infrastructure;

use App\Application\ProductResponse;
use App\Domain\Product;
use App\Infrastructure\CartDataJsonRepository;
use App\Infrastructure\ProductDataJsonRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class CartDataJsonRepositoryTest extends TestCase
{
    public function testCartCreate()
    {
        $cartManager = new CartDataJsonRepository(new ProductResponse());
        $result = $cartManager->cartCreate();
        $this->assertNotEmpty($result);
    }

    public function testAddToCart()
    {
        $cartManager = new CartDataJsonRepository(new ProductResponse());
        $productManager = new ProductDataJsonRepository(new ProductResponse());

        $product = new Product(Uuid::uuid4()->toString(), 'test1', 10, 1);
        $productManager->create($product);
        $cartUuid = $cartManager->cartCreate();

        $cartManager->addToCart($product, $cartUuid);
        $cart = $cartManager->findbyId($cartUuid);

        $expectedProductUuid = null;
        foreach ($cart->products() as $productCart) {
            if ($productCart->uuid() === $product->uuid()) {
                $expectedProductUuid = $product->uuid();
            }
        }

        $this->assertEquals($product->uuid(), $expectedProductUuid);
    }

    public function testDeteleToCart()
    {
        $cartManager = new CartDataJsonRepository(new ProductResponse());
        $productManager = new ProductDataJsonRepository(new ProductResponse());

        $product = new Product(Uuid::uuid4()->toString(), 'test1', 10, 1);
        $productManager->create($product);
        $cartUuid = $cartManager->cartCreate();

        $cartManager->addToCart($product, $cartUuid);
        $cartManager->deleteToCart($product, $cartUuid);
        $cart = $cartManager->findbyId($cartUuid);

        $expectedProductUuid = null;
        foreach ($cart->products() as $productCart) {
            if ($productCart->uuid() === $product->uuid()) {
                $expectedProductUuid = $product->uuid();
            }
        }

        $this->assertNull($expectedProductUuid);
    }

    public function testPay()
    {
        $cartManager = new CartDataJsonRepository(new ProductResponse());
        $productManager = new ProductDataJsonRepository(new ProductResponse());

        $product = new Product(Uuid::uuid4()->toString(), 'test1', 10, 1);
        $productManager->create($product);
        $cartUuid = $cartManager->cartCreate();

        $cartManager->addToCart($product, $cartUuid);
        $cartManager->pay($cartUuid);
        $cart = $cartManager->findbyId($cartUuid);

        self::assertNull($cart);
    }
}
