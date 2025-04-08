<?php

declare(strict_types=1);

namespace App\GraphQL\InputType;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Input type for a selected attribute in GraphQL.
 */
class SelectedAttributeInputType extends InputObjectType
{
    /**
     * Initializes the SelectedAttributeInputType.
     */
    public function __construct()
    {
        parent::__construct([
            'name' => 'SelectedAttributeInput',
            'fields' => [
                'attributeSetId' =>  Type::nonNull(Type::string()),
                'attributeId' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}
