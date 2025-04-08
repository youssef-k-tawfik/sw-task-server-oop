<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Config\Container;

/**
 * GraphQL ObjectType for representing an attribute set.
 */
class AttributeSetType extends ObjectType
{
    /**',
     * Constructor to define the fields and structure of the AttributeSetType.
     *
     * @param Container $container The dependency injection container for resolving types.
     */
    public function __construct(Container $container)
    {
        parent::__construct([
            'name'   => 'AttributeSet',
            'fields' => [
                'id'    => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($attributeSet) => $attributeSet->getId()
                ],
                'name'  => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($attributeSet) => $attributeSet->getName()
                ],
                'type'  => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($attributeSet) => $attributeSet->getType()
                ],
                'items' => [
                    'type'    => Type::listOf(
                        $container->get(AttributeType::class)
                    ),
                    'resolve' => fn($attributeSet) => $attributeSet->getItems()
                ],
            ],
        ]);
    }
}
