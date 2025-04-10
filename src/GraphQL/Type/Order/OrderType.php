<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Order;

use App\Config\Container;
use App\GraphQL\Type\CurrencyType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * GraphQL ObjectType for representing an order.
 */
class OrderType extends ObjectType
{
    /**
     * Constructor to define the fields and structure of the OrderType.
     *
     * @param Container $container The dependency injection container for resolving types.
     */
    public function __construct(Container $container)
    {
        parent::__construct([
            'name'   => 'Order',
            'fields' => [
                'orderNumber' => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($order) => $order->getOrderNumber(),
                ],
                'totalAmount' => [
                    'type'    => Type::nonNull(Type::float()),
                    'resolve' => fn($order) => $order->getTotalAmount(),
                ],
                'currency' => [
                    'type'    => Type::nonNull($container->get(
                        CurrencyType::class
                    )),
                    'resolve' => fn($order) => $order->getCurrency(),
                ],
                'placedAt' => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($order) => $order->getPlacedAt()->format("F d, Y, h:i A"),
                ],
                'products' => [
                    'type'    => Type::listOf(
                        $container->get(OrderProductType::class)
                    ),
                    'resolve' => fn($order) => $order->getProducts(),
                ],
            ],
        ]);
    }
}
