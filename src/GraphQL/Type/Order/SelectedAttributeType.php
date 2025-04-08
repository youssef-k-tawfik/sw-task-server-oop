<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Order;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * GraphQL ObjectType for representing a selected attribute in an order.
 */
class SelectedAttributeType extends ObjectType
{
    /**
     * Constructor to define the fields and structure of the SelectedAttributeType.
     */
    public function __construct()
    {
        parent::__construct([
            'name'   => 'SelectedAttribute',
            'fields' => [
                'attributeSetId' => [
                    'type'    => Type::string(),
                    'resolve' => fn($selectedAttribute) => $selectedAttribute->getAttributeSetId()
                ],
                'attributeId'    => [
                    'type'    => Type::string(),
                    'resolve' => fn($selectedAttribute) => $selectedAttribute->getAttributeId()
                ],
            ],
        ]);
    }
}
