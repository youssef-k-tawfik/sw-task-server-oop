<?php

declare(strict_types=1);

namespace App\Entity\AttributeSet;

/**
 * Represents an attribute within an attribute set.
 *
 * @property string $id           The unique identifier of the attribute.
 * @property string $value        The value of the attribute.
 * @property string $displayValue The display value of the attribute.
 */
final class Attribute
{
    /**
     * @var string The unique identifier of the attribute.
     */
    protected string $id;

    /**
     * @var string The value of the attribute.
     */
    protected string $value;

    /**
     * @var string The display value of the attribute.
     */
    protected string $displayValue;

    /**
     * @param string $id           The unique identifier of the attribute.
     * @param string $value        The value of the attribute.
     * @param string $displayValue The display value of the attribute.
     */
    public function __construct(
        string $id,
        string $value,
        string $displayValue
    ) {
        $this->id           = $id;
        $this->value        = $value;
        $this->displayValue = $displayValue;
    }

    /**
     * Get the unique identifier of the attribute.
     *
     * @return string The unique identifier of the attribute.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the value of the attribute.
     *
     * @return string The value of the attribute.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get the display value of the attribute.
     *
     * @return string The display value of the attribute.
     */
    public function getDisplayValue(): string
    {
        return $this->displayValue;
    }
}
