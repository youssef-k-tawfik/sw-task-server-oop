<?php

declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;

/**
 * Class Database
 * Handles database connection using PDO.
 */
final class Database
{
    /**
     * @var PDO|null $connection The PDO connection instance or null if not connected.
     */
    private ?PDO $connection = null;

    /**
     * Establishes a connection to the database using environment variables.
     * 
     * @throws \RuntimeException If the connection fails or is already established.
     */
    public function connect(): void
    {
        if ($this->connection === null) {
            // Build the Data Source Name (DSN) string for PDO connection.
            $dsn = sprintf(
                '%s:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                $_ENV['DB_DRIVER'],
                $_ENV['DB_HOST'],
                $_ENV['DB_PORT'],
                $_ENV['DB_NAME']
            );

            try {
                // Create a new PDO instance with the specified DSN and credentials.
                $this->connection = new PDO(
                    $dsn,
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors.
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch results as associative arrays.
                        PDO::ATTR_EMULATE_PREPARES => false, // Use native prepared statements if supported.
                    ]
                );
            } catch (PDOException $e) {

                throw new \RuntimeException('Database connection error: ' . $e->getMessage());
            }
        } else {
            throw new \RuntimeException('Database is already connected!');
        }
    }

    /**
     * Disconnects from the database by setting the connection to null.
     */
    public function disconnect(): void
    {
        $this->connection = null;
    }

    /**
     * Retrieves the current PDO connection instance.
     * 
     * @return PDO The active PDO connection.
     * @throws \RuntimeException If the connection is not established.
     */
    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            throw new \RuntimeException('Database is not connected. Call connect() first.');
        }

        return $this->connection;
    }
}
