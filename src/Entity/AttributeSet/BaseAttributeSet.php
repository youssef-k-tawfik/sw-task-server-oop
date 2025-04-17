<?php

declare(strict_types=1);

namespace App\Entity\AttributeSet;

use App\Entity\Attribute\AttributeInterface;

/**
 * Base class for attribute sets.
 * 
 * @property string               $id    The unique identifier of the attribute set.
 * @property string               $name  The name of the attribute set.
 * @property string               $type  The type of the attribute set.
 * @property AttributeInterface[] $items The list of attributes in the set.
 */
abstract class BaseAttributeSet implements AttributeSetInterface
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(AttributeInterface $item): self
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

    public function hasItem(AttributeInterface $attribute): bool
    {
        foreach ($this->items as $existingAttribute) {
            if ($existingAttribute->getId() === $attribute->getId()) {
                return true;
            }
        }
        return false;
    }
}
