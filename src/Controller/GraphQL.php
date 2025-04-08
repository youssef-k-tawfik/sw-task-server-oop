<?php

declare(strict_types=1);

namespace App\Controller;

use GraphQL\GraphQL as GraphQLBase;
use RuntimeException;
use Throwable;

use App\Config\Container;
use App\GraphQL\GraphQLSchema;
use App\Utils\CustomLogger;

/**
 * Class GraphQL
 * Handles GraphQL requests and responses.
 */
final class GraphQL
{
    /**
     * Handles a GraphQL request.
     *
     * @param Container $container Dependency injection container.
     * @return string JSON-encoded response.
     */
    public static function handle(Container $container): string
    {
        try {
            // build schema
            $schema = GraphQLSchema::build($container);

            // parse input
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            // decode input
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;

            // execute query
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery(
                $schema,
                $query,
                $rootValue,
                null,
                $variableValues
            );
            $output = $result->toArray();
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        CustomLogger::logInfo('GraphQL responding');
        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}
