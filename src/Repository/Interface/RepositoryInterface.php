<?php

declare(strict_types=1);

namespace App\Repository\Interface;

interface RepositoryInterface
{
    /**
     * Begin a database transaction.
     */
    public function beginTransaction(): void;

    /**
     * Commit the current database transaction.
     */
    public function commit(): void;

    /**
     * Roll back the current database transaction.
     */
    public function rollBack(): void;
}
