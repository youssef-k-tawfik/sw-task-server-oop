<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * GraphQL ObjectType for representing an attribute.
 */
class AttributeType extends ObjectType
{
    /**
     * Constructor to define the fields and structure of the AttributeType.
     */
    public function __construct()
    {
        parent::__construct([
            'name'   => 'Attribute',
            'fields' => [
                'id'           => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($attribute) => $attribute->getId()
                ],
                'value'        => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($attribute) => $attribute->getValue()
                ],
                'displayValue' => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($attribute) => $attribute->getDisplayValue()
                ],
            ],
        ]);
    }
}
