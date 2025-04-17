<?php

declare(strict_types=1);

namespace App\Entity\Attribute;

interface AttributeInterface
{
    /**
     * Get the unique identifier of the attribute.
     *
     * @return string The unique identifier of the attribute.
     */
    public function getId(): string;

    /**
     * Get the value of the attribute.
     *
     * @return string The value of the attribute.
     */
    public function getValue(): string;

    /**
     * Get the display value of the attribute.
     *
     * @return string The display value of the attribute.
     */
    public function getDisplayValue(): string;
}
