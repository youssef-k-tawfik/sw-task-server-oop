<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Category\CategoryInterface;
use App\Entity\Category\AllCategory;
use App\Entity\Category\TechCategory;
use App\Entity\Category\ClothesCategory;

/**
 * Factory for creating category instances.
 */
class CategoryFactory
{
    /**
     * @var array<string, string> Mapping of category names to their corresponding classes.
     */
    private static array $categoryMap = [
        'all'     => AllCategory::class,
        'tech'    => TechCategory::class,
        'clothes' => ClothesCategory::class,
    ];

    /**
     * Create a category instance.
     *
     * @param string $categoryName The name of the category (e.g., "all", "tech", "clothes").
     * @return CategoryInterface        The created category instance.
     * @throws \InvalidArgumentException If the category name is unknown.
     */
    public static function create(string $categoryName): CategoryInterface
    {
        $name = strtolower($categoryName);
        if (!isset(self::$categoryMap[$name])) {
            throw new \InvalidArgumentException("Unknown category name: {$name}");
        }
        $categoryClass = self::$categoryMap[$name];
        return new $categoryClass($name);
    }
}
