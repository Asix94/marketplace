## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to start the project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Products

create product.

- **Endpoint: https://localhost/product/create?name=product1&price=100:
- **Response**: {'af7c1fe6-d669-414e-b066-e9733f0de7a8'}.

## Shop Market

add product to cart.

- **Endpoint: https://localhost/shop/add-to-cart?product_uuid=8d2a95bc-9e67-45c5-a2df-bc47df75988e:
- **Response**: {Add to card Success}.

delete product to cart.

- **Endpoint: https://localhost/shop/delete-to-cart?product_uuid=8d2a95bc-9e67-45c5-a2df-bc47df75988e&cart_uuid=d1f409f8-a030-49e3-b657-89dea8f96d45:
- **Response**: {delete to card Success}.

pay cart

- **Endpoint: https://localhost/shop/pay?uuid=d1f409f8-a030-49e3-b657-89dea8f96d45:
- **Response**: {pay Success}.
