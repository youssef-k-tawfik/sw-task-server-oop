<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver;

use App\Service\ProductService;

/**
 * Resolver for handling product-related GraphQL queries.
 */
class ProductResolver
{
    /**
     * @var ProductService Service for handling product-related operations.
     */
    private ProductService $productService;

    /**
     * Constructor to initialize the ProductResolver with a ProductService instance.
     *
     * @param ProductService $productService The service used for fetching products.
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Retrieves products based on the provided arguments.
     *
     * @param object $root The root object (not used in this method).
     * @param array  $args The arguments containing filters like category or product ID.
     * @return array The list of products matching the criteria.
     * @throws \Exception If an error occurs while resolving products.
     */
    public function getProducts($root, $args): array
    {
        try {
            $category  = $args['category'] ?? null;
            $brand     = $args['brand'] ?? null;
            $productId = $args['id'] ?? null;

            return $this->productService->getProducts(
                $category,
                $brand,
                $productId
            );
        } catch (\Exception $e) {
            throw new \Exception("Error resolving products: {$e->getMessage()}");
        }
    }
}
