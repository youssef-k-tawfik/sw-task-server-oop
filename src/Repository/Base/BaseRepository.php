<?php

declare(strict_types=1);

namespace App\Repository\Base;

use App\Repository\Interface\RepositoryInterface;
use PDO;

/**
 * Base repository providing common database operations.
 */
abstract class BaseRepository implements RepositoryInterface
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

    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function commit(): void
    {
        $this->connection->commit();
    }

    public function rollBack(): void
    {
        $this->connection->rollBack();
    }
}
