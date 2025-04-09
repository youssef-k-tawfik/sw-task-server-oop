<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\ProductFactory;
use App\Repository\ProductRepository;
use App\Utils\CustomLogger;

/**
 * Service for handling product-related operations.
 */
final class ProductService
{
    /**
     * @var ProductRepository $productRepository The repository for fetching products.
     */
    private ProductRepository $productRepository;

    /**
     * Constructor to initialize the ProductService.
     *
     * @param ProductRepository $productRepository The repository for products.
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Fetches a list of products from the repository, optionally filtered by category and product ID.
     *
     * @param string|null $category  Optional category filter.
     * @param string|null $productId Optional product ID filter.
     * @return array                 List of products.
     * @throws \Exception            If no products are found or an error occurs during fetching.
     */
    public function getProducts(
        ?string $category = null,
        ?string $brand = null,
        ?string $productId = null
    ): array {
        try {
            $results = $this->productRepository->getProducts(
                $category,
                $brand,
                $productId
            );
            $products = $this->processProductResults($results);

            CustomLogger::debug(__FILE__, __LINE__, $products);
            return $products;
        } catch (\Exception $e) {
            CustomLogger::logInfo("Error serving products with category '{$category}' and product ID '{$productId}': {$e->getMessage()}");
            throw new \Exception("Error serving products: {$e->getMessage()}");
        }
    }

    /**
     * Converts raw product data into structured product entities.
     *
     * @param array $results The raw product data retrieved from the repository.
     * @return array         An array of processed product entities.
     * @throws \Exception    If the results array is empty.
     */
    private function processProductResults(array $results): array
    {
        if (empty($results)) {
            throw new \Exception("No products found.");
        }

        $products = [];
        foreach ($results as $row) {
            $gallery = explode('|', $row['gallery_urls']);

            $products[] = ProductFactory::create(
                $row['id'],
                $row['name'],
                (bool)$row['in_stock'],
                $gallery,
                $row['description'],
                $row['category_name'],
                $row['brand_name']
            );
        }

        return $products;
    }
}
