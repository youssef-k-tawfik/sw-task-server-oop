<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * GraphQL ObjectType for representing a category.
 */
class CategoryType extends ObjectType
{
    /**
     * Constructor to define the fields and structure of the CategoryType.
     */
    public function __construct()
    {
        parent::__construct([
            'name'   => 'Category',
            'fields' => [
                'name' => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($category) => $category->getName(),
                ],
            ],
        ]);
    }
}
