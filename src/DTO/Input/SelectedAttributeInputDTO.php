<?php

declare(strict_types=1);

namespace App\DTO\Input;

/**
 * Data Transfer Object for Selected Attribute Input.
 *
 * @property string $attributeSetId The ID of the attribute set.
 * @property string $attributeId    The ID of the attribute.
 */
final class SelectedAttributeInputDTO
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
     * Get the attribute set ID.
     *
     * @return string The ID of the attribute set.
     */
    public function getAttributeSetId(): string
    {
        return $this->attributeSetId;
    }

    /**
     * Get the attribute ID.
     *
     * @return string The ID of the attribute.
     */
    public function getAttributeId(): string
    {
        return $this->attributeId;
    }
}
