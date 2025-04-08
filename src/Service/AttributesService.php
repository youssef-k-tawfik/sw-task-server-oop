<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AttributeSet\Attribute;
use App\Factory\AttributeSetFactory;
use App\Repository\AttributesRepository;
use App\Utils\CustomLogger;

/**
 * Service for handling attribute-related operations.
 */
class AttributesService
{
    /**
     * @var AttributesRepository The repository for fetching attributes.
     */
    private AttributesRepository $attributesRepository;

    /**
     * Constructor to initialize the AttributesService.
     *
     * @param AttributesRepository $attributesRepository The repository for attributes.
     */
    public function __construct(AttributesRepository $attributesRepository)
    {
        $this->attributesRepository = $attributesRepository;
    }

    /**
     * Fetch and process attributes for a given product ID.
     *
     * @param string $productId The ID of the product to fetch attributes for.
     * @return array            The processed list of attribute sets.
     * @throws \Exception       If an error occurs while fetching attributes.
     */
    public function getAttributes(string $productId): array
    {
        try {
            $results = $this->attributesRepository->getAttributes($productId);
            $attributes = $this->processAttributeResults($results);

            CustomLogger::debug(__FILE__, __LINE__, $attributes);
            return $attributes;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching attributes: {$e->getMessage()}");
        }
    }

    /**
     * Process raw attribute results into structured attribute sets.
     *
     * @param array $results The raw attribute data from the repository.
     * @return array         The structured list of attribute sets.
     */
    private function processAttributeResults(array $results): array
    {
        $attributeSets = [];

        foreach ($results as $row) {
            // create attribute set if it doesn't exist
            $attributeSetId = $row['attribute_set_id'];
            if (!isset($attributeSets[$attributeSetId])) {
                $attributeSets[$attributeSetId] = AttributeSetFactory::create(
                    $row['attribute_set_id'],
                    $row['attribute_set_name'],
                    $row['attribute_set_type']
                );
            }

            // create attribute and add it to the set if it doesn't exist
            $attribute = new Attribute(
                $row['attribute_id'],
                $row['value'],
                $row['display_value']
            );
            if (!$attributeSets[$attributeSetId]->hasItem($attribute)) {
                $attributeSets[$attributeSetId]->addItem($attribute);
            }
        }

        return array_values($attributeSets);
    }
}
