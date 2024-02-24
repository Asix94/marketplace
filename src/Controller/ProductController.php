<?php

namespace App\Controller;

use App\Application\ProductResponse;
use App\Application\ProductsResponse;
use App\Domain\Product;
use App\Domain\ProductRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {}

    /**
     * @Route("/product/create", name="createProduct")
     */
    public function createProduct(Request $request): JsonResponse
    {
        $product = new Product(
            Uuid::uuid4()->toString(),
            $request->query->get('name'),
            $request->query->get('price'),
            1
        );

        try {
            $this->productRepository->create($product);
            return $this->json($product->uuid());
        } catch (Exception $e) {
            return $this->json('Error');
        }
    }
}
