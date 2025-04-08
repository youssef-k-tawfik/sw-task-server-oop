<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\Config\Container;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\GraphQL\Resolver\AttributesResolver;
use App\GraphQL\Resolver\PriceResolver;

/**
 * GraphQL ObjectType for representing a product.
 */
class ProductType extends ObjectType
{
    /**
     * Constructor to define the fields and structure of the ProductType.
     *
     * @param Container $container The dependency injection container for resolving types.
     */
    public function __construct(Container $container)
    {
        parent::__construct([
            'name'   => 'Product',
            'fields' => [
                'id'          => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($product) => $product->getId()
                ],
                'name'        => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($product) => $product->getName()
                ],
                'description' => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($product) => $product->getDescription()
                ],
                'inStock'     => [
                    'type'    => Type::boolean(),
                    'resolve' => fn($product) => $product->isInStock()
                ],
                'brand'       => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($product) => $product->getBrand()
                ],
                'category'    => [
                    'type'    => Type::nonNull(Type::string()),
                    'resolve' => fn($product) => $product->getCategory()->getName()
                ],
                'gallery'     => [
                    'type'    => Type::listOf(Type::nonNull(Type::string())),
                    'resolve' => fn($product) => $product->getGallery()
                ],
                'prices'      => [
                    'type'    => Type::listOf(Type::nonNull(
                        $container->get(PriceType::class)
                    )),
                    'resolve' => [
                        $container->get(PriceResolver::class),
                        'getAllPrices'
                    ]
                ],
                'attributes'  => [
                    'type'    => Type::listOf(Type::nonNull(
                        $container->get(AttributeSetType::class)
                    )),
                    'resolve' => [
                        $container->get(AttributesResolver::class),
                        'getAttributes'
                    ]
                ],
            ],
        ]);
    }
}
