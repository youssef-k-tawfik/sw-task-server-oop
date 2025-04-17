<?php

declare(strict_types=1);

namespace App\Entity\Category;

use App\Entity\Category\Base\BaseCategory;

/**
 * Represents the "clothes" category.
 */
final class ClothesCategory extends BaseCategory
{
    /**
     * @var string The name of the "clothes" category.
     */
    private const NAME = 'clothes';

    public function __construct()
    {
        parent::__construct(self::NAME);
    }
}
