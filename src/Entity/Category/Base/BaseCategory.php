<?php

declare(strict_types=1);

namespace App\Entity\Category\Base;

use App\Entity\Category\Interface\CategoryInterface;

/**
 * Base class for categories.
 *
 * @property string $name The name of the category.
 */
abstract class BaseCategory implements CategoryInterface
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

    public function getName(): string
    {
        return $this->name;
    }
}
