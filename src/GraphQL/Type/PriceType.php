<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\Config\Container;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * GraphQL ObjectType for representing a price.
 */
class PriceType extends ObjectType
{
    /**
     * Constructor to define the fields and structure of the PriceType.
     *
     * @param Container $container The dependency injection container for resolving types.
     */
    public function __construct(Container $container)
    {
        parent::__construct([
            'name'   => 'Price',
            'fields' => [
                'amount'   => [
                    'type'    => Type::nonNull(Type::float()),
                    'resolve' => fn($price) => $price->getAmount()
                ],
                'currency' => [
                    'type'    => Type::nonNull(
                        $container->get(CurrencyType::class)
                    ),
                    'resolve' => fn($price) => $price->getCurrency()
                ],
            ],
        ]);
    }
}
