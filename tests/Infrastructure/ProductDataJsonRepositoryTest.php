<?php

namespace Infrastructure;

use App\Application\ProductResponse;
use App\Domain\Product;
use App\Infrastructure\ProductDataJsonRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ProductDataJsonRepositoryTest extends TestCase
{
    public function testCreate(): void {
        $testProduct = new Product(Uuid::uuid4()->toString(),'test1',10, 1);
        $repository = new ProductDataJsonRepository(new ProductResponse());
        $result = $repository->create($testProduct);
        $this->assertNotEmpty($result);
        $this->assertEquals($testProduct->uuid(), $result);
    }

    public function testFindById()
    {
        $repository = new ProductDataJsonRepository(new ProductResponse());
        $uuid = '12345678-1234-5678-1234-567812345678';
        $testProduct = new Product($uuid,'test1',10, 1);
        $repository->create($testProduct);
        $result = $repository->findById($uuid);
        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals($uuid, $result->uuid());
    }
}
