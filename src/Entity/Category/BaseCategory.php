<?php

declare(strict_types=1);

namespace App\Entity\Category;

/**
 * Base class for categories.
 *
 * @property string $name The name of the category.
 */
abstract class BaseCategory
{
    /**
     * @var string The name of the category.
     */
    protected string $name;

    /**
     * @param string $name The name of the category.
     */
    public function __construct(string $name)
    {
        $this->name = strtolower(trim($name));
    }

    /**
     * Get the name of the category.
     *
     * @return string The name of the category.
     */
    public function getName(): string
    {
        return $this->name;
    }
}
