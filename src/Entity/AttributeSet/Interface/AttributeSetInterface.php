<?php

declare(strict_types=1);

namespace App\Entity\AttributeSet\Interface;

use App\Entity\Attribute\Attribute;
use App\Entity\Attribute\Interface\AttributeInterface;

interface AttributeSetInterface
{
    /**
     * Get the ID of the attribute set.
     *
     * @return string The unique identifier of the attribute set.
     */
    public function getId(): string;

    /**
     * Get the name of the attribute set.
     *
     * @return string The name of the attribute set.
     */
    public function getName(): string;

    /**
     * Get the type of the attribute set.
     *
     * @return string The type of the attribute set.
     */
    public function getType(): string;

    /**
     * Get the list of attributes in the set.
     *
     * @return Attribute[] The list of attributes in the set.
     */
    public function getItems(): array;

    /**
     * Adds an attribute to the set and returns the updated AttributeSetInterface instance.
     *
     * @param Attribute $attribute The attribute instance to be added to the set.
     * @return AttributeSetInterface The updated instance of the attribute set.
     */
    public function addItem(AttributeInterface $attribute): AttributeSetInterface;

    /**
     * Checks if the attribute set contains the specified attribute.
     *
     * @param Attribute $attribute The attribute to check for existence in the set.
     * @return bool Returns true if the attribute exists in the set, false otherwise.
     */
    public function hasItem(AttributeInterface $attribute): bool;
}
