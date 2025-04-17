<?php

declare(strict_types=1);

namespace App\Entity\Category;

use App\Entity\Category\Base\BaseCategory;

/**
 * Represents the "all" category.
 */
final class AllCategory extends BaseCategory
{
    /**
     * @var string The name of the "all" category.
     */
    private const NAME = 'all';

    public function __construct()
    {
        parent::__construct(self::NAME);
    }
}
