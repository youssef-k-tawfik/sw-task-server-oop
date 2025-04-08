<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * GraphQL ObjectType for representing a currency.
 */
class CurrencyType extends ObjectType
{
    /**
     * Constructor to define the fields and structure of the CurrencyType.
     */
    public function __construct()
    {
        parent::__construct([
            'name'   => 'Currency',
            'fields' => [
                'symbol' => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($currency) => $currency->getSymbol()
                ],
                'label'  => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($currency) => $currency->getLabel()
                ],
            ],
        ]);
    }
}
