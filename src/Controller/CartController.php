<?php

namespace App\Controller;

use App\Domain\ProductRepository;
use App\Domain\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CartController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CartRepository $shopRepository
    ) {}
    /**
     * @Route("/shop/add-to-cart", name="adToCart")
     */
    public function addToCart(Request $request): JsonResponse
    {
        $productUuid = $request->query->get('product_uuid');
        $cartUuid = $request->query->get('cart_uuid');

        if ($cartUuid === null) {
            $cartUuid = $this->shopRepository->cartCreate();
        }
        $product = $this->productRepository->findById($productUuid);
        $this->shopRepository->addToCart($product, $cartUuid);
        return $this->json('Add to card Success');
    }
    /**
     * @Route("/shop/delete-to-cart", name="adToCart")
     */
    public function deleteToCart(Request $request): JsonResponse
    {
        $productUuid = $request->query->get('product_uuid');
        $cartUuid = $request->query->get('cart_uuid');
        $product = $this->productRepository->findById($productUuid);
        $this->shopRepository->deleteToCart($product, $cartUuid);
        return $this->json('Delete to card Success');
    }
    /**
     * @Route("/shop/pay", name="pay")
     */
    public function pay(Request $request): JsonResponse
    {
        $uuid = $request->query->get('uuid');
        $this->shopRepository->pay($uuid);
        return $this->json('pay success');
    }
}
