<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Order;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Config\Container;
use App\GraphQL\Type\ProductType;

/**
 * GraphQL ObjectType for representing an order product.
 */
class OrderProductType extends ObjectType
{
    /**
     * Constructor to define the fields and structure of the OrderProductType.
     *
     * @param Container $container The dependency injection container for resolving types.
     */
    public function __construct(Container $container)
    {
        parent::__construct([
            'name'   => 'OrderProduct',
            'fields' => [
                'product' => [
                    'type'    => Type::nonNull(
                        $container->get(ProductType::class)
                    ),
                    'resolve' => fn($orderProduct) => $orderProduct->getProduct(),
                ],
                'quantity' => [
                    'type'    => Type::nonNull(Type::int()),
                    'resolve' => fn($orderProduct) => $orderProduct->getQuantity(),
                ],
                'selectedAttributes' => [
                    'type'    => Type::listOf(
                        $container->get(SelectedAttributeType::class)
                    ),
                    'resolve' => fn($orderProduct) => $orderProduct->getSelectedAttributes(),
                ],
            ],
        ]);
    }
}
