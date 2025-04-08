<?php

declare(strict_types=1);

namespace App\Repository;

/**
 * Repository for handling category-related database operations.
 */
class CategoryRepository extends BaseRepository
{
    /**
     * Fetch all categories from the database.
     *
     * @return array An array of categories as associative arrays.
     * @throws PDOException If a database error occurs.
     */
    public function fetchAllCategories(): array
    {
        $stmt = $this->connection->query("SELECT * FROM category");
        return $stmt->fetchAll();
    }
}
