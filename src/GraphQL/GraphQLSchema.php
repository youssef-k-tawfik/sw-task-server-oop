<?php

declare(strict_types=1);

namespace App\GraphQL;

use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

use App\Config\Container;
use App\GraphQL\Factory\QueryTypeFactory;
use App\GraphQL\Factory\MutationTypeFactory;

/**
 * Class responsible for building the GraphQL schema.
 */
class GraphQLSchema
{
    /**
     * Build the GraphQL schema.
     *
     * @param Container $container The container to use for dependency injection.
     * @return Schema The constructed GraphQL schema.
     */
    public static function build(Container $container): Schema
    {
        $queryType = QueryTypeFactory::create($container);
        $mutationType = MutationTypeFactory::create($container);

        return new Schema(
            (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
        );
    }
}
