<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Product\Interface\ProductInterface;
use App\Entity\Product\TechProduct;
use App\Entity\Product\ClothesProduct;

/**
 * Factory for creating product instances.
 */
class ProductFactory
{
    /**
     * @var array<string, string> Mapping of product categories to their corresponding classes.
     */
    private static array $productMap = [
        'tech'    => TechProduct::class,
        'clothes' => ClothesProduct::class,
    ];

    /**
     * Create a product instance.
     *
     * @param string $id          The unique identifier of the product.
     * @param string $name        The name of the product.
     * @param bool   $inStock     Whether the product is in stock.
     * @param array  $gallery     The gallery of images for the product.
     * @param string $description The description of the product.
     * @param string $category    The category of the product (e.g., "tech", "clothes").
     * @param string $brand       The brand of the product.
     * @return ProductInterface        The created product instance.
     * @throws \InvalidArgumentException If the product category is unknown.
     */
    public static function create(
        string $id,
        string $name,
        bool   $inStock,
        array  $gallery,
        string $description,
        string $category,
        string $brand
    ): ProductInterface {
        $category = strtolower($category);
        if (!isset(self::$productMap[$category])) {
            throw new \InvalidArgumentException("Unknown product category: {$category}");
        }

        $productClass = self::$productMap[$category];
        return new $productClass(
            $id,
            $name,
            $inStock,
            $gallery,
            $description,
            $brand
        );
    }
}
