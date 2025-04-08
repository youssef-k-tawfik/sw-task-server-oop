<?php

declare(strict_types=1);

namespace App\Entity\Order;

/**
 * Represents a selected attribute in an order.
 *
 * @property string $attributeSetId The ID of the attribute set.
 * @property string $attributeId    The ID of the attribute.
 */
class SelectedAttribute
{
    /**
     * @var string The ID of the attribute set.
     */
    private string $attributeSetId;

    /**
     * @var string The ID of the attribute.
     */
    private string $attributeId;

    /**
     * @param string $attributeSetId The ID of the attribute set.
     * @param string $attributeId    The ID of the attribute.
     */
    public function __construct(
        string $attributeSetId,
        string $attributeId
    ) {
        $this->attributeSetId = $attributeSetId;
        $this->attributeId    = $attributeId;
    }

    /**
     * Get the ID of the attribute set.
     *
     * @return string The ID of the attribute set.
     */
    public function getAttributeSetId(): string
    {
        return $this->attributeSetId;
    }

    /**
     * Get the ID of the attribute.
     *
     * @return string The ID of the attribute.
     */
    public function getAttributeId(): string
    {
        return $this->attributeId;
    }
}
