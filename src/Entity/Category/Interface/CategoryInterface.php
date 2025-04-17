<?php

declare(strict_types=1);

namespace App\Entity\Category\Interface;

/**
 * Interface for category entities.
 */
interface CategoryInterface
{
    /**
     * Get the name of the category.
     *
     * @return string The name of the category.
     */
    public function getName(): string;
}
