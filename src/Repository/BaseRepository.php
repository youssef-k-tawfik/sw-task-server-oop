<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

/**
 * Base repository providing common database operations.
 */
abstract class BaseRepository
{
    /**
     * @var PDO The database connection instance.
     */
    protected PDO $connection;

    /**
     * Constructor to initialize the database connection.
     *
     * @param PDO $connection The PDO connection instance.
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Begin a database transaction.
     */
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    /**
     * Commit the current database transaction.
     */
    public function commit(): void
    {
        $this->connection->commit();
    }

    /**
     * Roll back the current database transaction.
     */
    public function rollBack(): void
    {
        $this->connection->rollBack();
    }
}
