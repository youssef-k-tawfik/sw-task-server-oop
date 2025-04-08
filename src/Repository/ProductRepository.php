<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product\BaseProduct;

/**
 * Repository class for managing product-related database operations.
 */
final class ProductRepository extends BaseRepository
{
    /**
     * Retrieve all products with optional filters for category and product ID.
     *
     * @param string|null $categoryName Filter by category name.
     * @param string|null $productId    Filter by product ID.
     * @return BaseProduct[] List of hydrated product entities.
     */
    public function getProducts(
        ?string $categoryName = null,
        ?string $productId = null
    ): array {
        $query = $this->buildProductQuery($categoryName, $productId);
        $params = $this->buildQueryParameters($categoryName, $productId);

        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    /**
     * Build the SQL query for fetching products.
     *
     * @param string|null $categoryName Filter by category name.
     * @param string|null $productId    Filter by product ID.
     * @return string The SQL query string.
     */
    private function buildProductQuery(
        ?string $categoryName,
        ?string $productId
    ): string {
        $query = "
        SELECT 
            p.id,
            p.name,
            p.in_stock,
            p.description,
            p.category_id,
            p.brand_id,
            c.name AS category_name,
            b.name AS brand_name,
            GROUP_CONCAT(g.url SEPARATOR '|') AS gallery_urls
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            LEFT JOIN brand b ON p.brand_id = b.id
            LEFT JOIN gallery g ON p.id = g.product_id
            WHERE 1=1
    ";

        if ($categoryName !== null) {
            $query .= " AND c.name = :categoryName";
        }
        if ($productId !== null) {
            $query .= " AND p.id = :productId";
        }

        $query .= " GROUP BY p.id";
        return $query;
    }

    /**
     * Build the query parameters for fetching products.
     *
     * @param string|null $categoryName Filter by category name.
     * @param string|null $productId    Filter by product ID.
     * @return array<string, string|null> The query parameters as key-value pairs.
     */
    private function buildQueryParameters(
        ?string $categoryName,
        ?string $productId
    ): array {
        $params = [];
        if ($categoryName !== null) {
            $params[':categoryName'] = $categoryName;
        }
        if ($productId !== null) {
            $params[':productId'] = $productId;
        }
        return $params;
    }
}
