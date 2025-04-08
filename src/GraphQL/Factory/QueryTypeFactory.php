<?php

declare(strict_types=1);

namespace App\GraphQL\Factory;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Config\Container;

use App\GraphQL\Type\CategoryType;
use App\GraphQL\Type\ProductType;
use App\GraphQL\Type\Order\OrderType;

use App\GraphQL\Resolver\CategoryResolver;
use App\GraphQL\Resolver\ProductResolver;
use App\GraphQL\Resolver\OrderResolver;

/**
 * Factory for creating the GraphQL Query type.
 */
class QueryTypeFactory
{
    /**
     * Create the Query type for GraphQL.
     *
     * @param Container $container The dependency injection container.
     * @return ObjectType          The Query type definition.
     */
    public static function create(Container $container): ObjectType
    {
        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf(
                        $container->get(CategoryType::class)
                    ),
                    'resolve' => [
                        $container->get(CategoryResolver::class),
                        'getCategories',
                    ],
                ],
                'products' => [
                    'type' => Type::listOf(
                        $container->get(ProductType::class)
                    ),
                    'args' => [
                        'category' => Type::string(),
                        'id' => Type::string(),
                    ],
                    'resolve' => [
                        $container->get(ProductResolver::class),
                        'getProducts',
                    ],
                ],
                'orders' => [
                    'type' => Type::listOf(
                        $container->get(OrderType::class)
                    ),
                    'args' => [
                        'orderNumbers' => Type::listOf(Type::string()),
                    ],
                    'resolve' => [
                        $container->get(OrderResolver::class),
                        'getOrders',
                    ],
                ],
            ],
        ]);
    }
}
