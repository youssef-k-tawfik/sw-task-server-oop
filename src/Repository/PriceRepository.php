<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Base\BaseRepository;

/**
 * Repository for handling price-related database operations.
 */
class PriceRepository extends BaseRepository
{
    /**
     * Fetch all prices for a given product ID.
     *
     * @param string $productId The ID of the product to fetch prices for.
     * @return array            The list of prices with currency labels.
     */
    public function getAllPrices(string $productId): array
    {
        $query = "
        SELECT 
            p.amount,
            c.label AS currency_label 
        FROM price p
        INNER JOIN currency c ON p.currency_id = c.id
        WHERE p.product_id = :productId";

        $stmt = $this->connection->prepare($query);
        $stmt->execute([':productId' => $productId]);
        return $stmt->fetchAll();
    }
}
