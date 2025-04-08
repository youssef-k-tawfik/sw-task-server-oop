<?php

declare(strict_types=1);

namespace App\GraphQL\Factory;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Config\Container;
use App\GraphQL\Type\Order\PlaceOrderResponseType;
use App\GraphQL\InputType\CartItemInputType;
use App\GraphQL\Resolver\OrderResolver;

/**
 * Factory for creating the GraphQL Mutation type.
 */
class MutationTypeFactory
{
    /**
     * Create the Mutation type for GraphQL.
     *
     * @param Container $container The dependency injection container.
     * @return ObjectType          The Mutation type definition.
     */
    public static function create(Container $container): ObjectType
    {
        return new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'placeOrder' => [
                    'type' => $container->get(PlaceOrderResponseType::class),
                    'args' => [
                        'cartItems' => [
                            'type' => Type::listOf(
                                $container->get(CartItemInputType::class)
                            ),
                        ],
                        'currencyLabel' => [
                            'type' => Type::nonNull(Type::string()),
                        ],
                    ],
                    'resolve' => [
                        $container->get(OrderResolver::class),
                        'placeOrder',
                    ],
                ],
            ],
        ]);
    }
}
