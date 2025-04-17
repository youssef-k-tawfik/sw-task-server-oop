<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Base\BaseRepository;

/**
 * Repository class for managing product-related database operations.
 */
final class ProductRepository extends BaseRepository
{
    /**
     * Retrieve all products with optional filters for category, brand, and product ID.
     *
     * @param string|null $category  Filter by category name (optional).
     * @param string|null $brand     Filter by brand name (optional).
     * @param string|null $productId Filter by product ID (optional).
     * @return array<int, array<string, mixed>> List of products as associative arrays.
     */
    public function getProducts(
        ?string $category = null,
        ?string $brand = null,
        ?string $productId = null
    ): array {
        $query = $this->buildProductQuery(
            $category,
            $brand,
            $productId
        );
        $params = $this->buildQueryParameters(
            $category,
            $brand,
            $productId
        );

        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    /**
     * Build the SQL query for fetching products.
     *
     * @param string|null $category  Filter by category name.
     * @param string|null $brand     Filter by brand name.
     * @param string|null $productId Filter by product ID.
     * @return string The SQL query string.
     */
    private function buildProductQuery(
        ?string $category,
        ?string $brand,
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

        $filters = [
            ':category'  => $category  ? " AND c.name = :category"  : null,
            ':brand'     => $brand     ? " AND b.name = :brand"     : null,
            ':productId' => $productId ? " AND p.id   = :productId" : null,
        ];

        foreach ($filters as $key => $condition) {
            if ($condition !== null) {
                $query .= $condition;
            }
        }

        $query .= " GROUP BY p.id";
        return $query;
    }

    /**
     * Build the query parameters for fetching products.
     *
     * @param string|null $category  Filter by category name.
     * @param string|null $brand     Filter by brand name.
     * @param string|null $productId Filter by product ID.
     * @return array<string, string|null> The query parameters as key-value pairs.
     */
    private function buildQueryParameters(
        ?string $category,
        ?string $brand,
        ?string $productId
    ): array {
        $params = [
            ':category'  => $category,
            ':brand'     => $brand,
            ':productId' => $productId,
        ];

        return array_filter(
            $params,
            fn($value) => $value !== null
        );
    }
}
