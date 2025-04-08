<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver;

use App\Service\AttributesService;

/**
 * Resolver for fetching attributes in GraphQL.
 */
class AttributesResolver
{
    /**
     * @var AttributesService The service for retrieving attributes.
     */
    private AttributesService $attributesService;

    /**
     * @param AttributesService $attributesService The service for retrieving attributes.
     */
    public function __construct(AttributesService $attributesService)
    {
        $this->attributesService = $attributesService;
    }

    /**
     * Resolve attributes for a given product.
     *
     * @param mixed $root The root object, expected to have a `getId` method.
     * @return array      The resolved attributes.
     * @throws \Exception If an error occurs during attribute resolution.
     */
    public function getAttributes($root): array
    {
        try {
            $productId = $root->getId();
            $attributes = $this->attributesService->getAttributes($productId);
            return $attributes;
        } catch (\Exception $e) {
            throw new \Exception("Error resolving attributes: {$e->getMessage()}");
        }
    }
}
