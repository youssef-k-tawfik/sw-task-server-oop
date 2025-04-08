<?php

declare(strict_types=1);

namespace App\Entity\AttributeSet;

/**
 * Base class for attribute sets.
 *
 * @property string      $id    The unique identifier of the attribute set.
 * @property string      $name  The name of the attribute set.
 * @property string      $type  The type of the attribute set.
 * @property Attribute[] $items The list of attributes in the set.
 */
abstract class BaseAttributeSet
{
    /**
     * @var string The unique identifier of the attribute set.
     */
    private string $id;

    /**
     * @var string The name of the attribute set.
     */
    private string $name;

    /**
     * @var string The type of the attribute set.
     */
    private string $type;

    /**
     * @var Attribute[] The list of attributes in the set.
     */
    private array $items = [];

    /**
     * @param string      $id    The unique identifier of the attribute set.
     * @param string      $name  The name of the attribute set.
     * @param string      $type  The type of the attribute set.
     * @param Attribute[] $items The list of attributes in the set.
     */
    public function __construct(
        string $id,
        string $name,
        string $type,
        array $items = []
    ) {
        $this->id    = $id;
        $this->name  = $name;
        $this->type  = $type;
        $this->items = $items;
    }

    /**
     * Get the ID of the attribute set.
     *
     * @return string The unique identifier of the attribute set.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the name of the attribute set.
     *
     * @return string The name of the attribute set.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the type of the attribute set.
     *
     * @return string The type of the attribute set.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Add an attribute to the set.
     *
     * @param Attribute $item The attribute to add.
     * @return self
     */
    public function addItem(Attribute $item): self
    {
        if (!in_array(
            $item,
            $this->items,
            true
        )) {
            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * Get all attributes in the set.
     *
     * @return Attribute[] The list of attributes in the set.
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Check if the set contains a specific attribute.
     *
     * @param Attribute $attribute The attribute to check.
     * @return bool True if the attribute exists in the set, false otherwise.
     */
    public function hasItem(Attribute $attribute): bool
    {
        foreach ($this->items as $existingAttribute) {
            if ($existingAttribute->getId() === $attribute->getId()) {
                return true;
            }
        }
        return false;
    }
}
