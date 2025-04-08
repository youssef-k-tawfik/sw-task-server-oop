<?php

declare(strict_types=1);

namespace App\GraphQL\InputType;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use App\Config\Container;

/**
 * Input type for a cart item in GraphQL.
 */
class CartItemInputType extends InputObjectType
{
    /**
     * @param Container $container The dependency injection container.
     */
    public function __construct(Container $container)
    {
        parent::__construct([
            'name' => 'CartItemInput',
            'fields' => [
                'productId' => Type::nonNull(Type::string()),
                'quantity' => Type::nonNull(Type::int()),
                'selectedAttributes' => Type::listOf(
                    $container->get(SelectedAttributeInputType::class)
                ),
            ],
        ]);
    }
}
