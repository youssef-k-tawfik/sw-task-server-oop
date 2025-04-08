<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Order;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * GraphQL ObjectType for representing the response of placing an order.
 */
class PlaceOrderResponseType extends ObjectType
{
    /**
     * Constructor to define the fields and structure of the PlaceOrderResponseType.
     */
    public function __construct()
    {
        parent::__construct([
            'name'   => 'PlaceOrderResponse',
            'fields' => [
                'order_number' => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($orderResponse) => $orderResponse->getOrderNumber(),
                ],
            ],
        ]);
    }
}
