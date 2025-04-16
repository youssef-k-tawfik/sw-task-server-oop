<?php

declare(strict_types=1);

namespace App\Entity\Product;

use App\Factory\CategoryFactory;

/**
 * Represents a product in the "tech" category.
 */
final class TechProduct extends BaseProduct
{

    /**
     * The category of the product.
     */
    private const CATEGORY = 'tech';

    /**
     * @param string $id          The unique identifier of the product.
     * @param string $name        The name of the product.
     * @param bool   $inStock     Whether the product is in stock.
     * @param array  $gallery     The gallery of images for the product.
     * @param string $description The description of the product.
     * @param string $brand       The brand of the product.
     */
    public function __construct(
        string $id,
        string $name,
        bool $inStock,
        array $gallery,
        string $description,
        string $brand
    ) {
        parent::__construct(
            $id,
            $name,
            $inStock,
            $gallery,
            $description,
            CategoryFactory::create(self::CATEGORY),
            $brand
        );
    }
}
