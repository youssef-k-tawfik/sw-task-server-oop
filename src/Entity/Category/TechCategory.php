<?php

declare(strict_types=1);

namespace App\Entity\Category;

use App\Entity\Category\Base\BaseCategory;

/**
 * Represents the "tech" category.
 */
final class TechCategory extends BaseCategory
{
    /**
     * @var string The name of the "tech" category.
     */
    private const NAME = 'tech';

    /**
     * Initializes the "tech" category.
     */
    public function __construct()
    {
        parent::__construct(self::NAME);
    }
}
