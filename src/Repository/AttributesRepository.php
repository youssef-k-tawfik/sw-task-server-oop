<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Base\BaseRepository;

/**
 * Repository for handling attribute-related database operations.
 */
class AttributesRepository extends BaseRepository
{
    /**
     * Fetch attributes for a given product ID.
     *
     * @param string $productId The ID of the product to fetch attributes for.
     * @return array            The list of attributes associated with the product.
     */
    public function getAttributes(string $productId): array
    {
        $query = "
        SELECT 
            a.id AS attribute_id,
            a.value, a.display_value,
            aset.id AS attribute_set_id,
            aset.name AS attribute_set_name,
            aset.type AS attribute_set_type
        FROM product_attributes pa
        INNER JOIN attribute a ON pa.attribute_id = a.id
        INNER JOIN attribute_set aset ON a.attribute_set_id = aset.id
        WHERE pa.product_id = :productId";

        $stmt = $this->connection->prepare($query);
        $stmt->execute([':productId' => $productId]);
        return $stmt->fetchAll();
    }
}
