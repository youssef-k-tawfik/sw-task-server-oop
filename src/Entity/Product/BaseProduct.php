<?php

declare(strict_types=1);

namespace App\Entity\Product;

use App\Entity\Category\BaseCategory;

/**
 * Base class for products.
 *
 * @property string       $id          The unique identifier of the product.
 * @property string       $name        The name of the product.
 * @property bool         $inStock     Whether the product is in stock.
 * @property array        $gallery     The gallery of images for the product.
 * @property string       $description The description of the product.
 * @property BaseCategory $category    The category of the product.
 * @property string       $brand       The brand of the product.
 */
abstract class BaseProduct
{
    /**
     * @var string The unique identifier of the product.
     */
    protected string $id;

    /**
     * @var string The name of the product.
     */
    protected string $name;

    /**
     * @var bool Whether the product is in stock.
     */
    protected bool $inStock;

    /**
     * @var array The gallery of images for the product.
     */
    protected array $gallery;

    /**
     * @var string The description of the product.
     */
    protected string $description;

    /**
     * @var BaseCategory The category of the product.
     */
    protected BaseCategory $category;

    /**
     * @var string The brand of the product.
     */
    protected string $brand;

    /**
     * @param string       $id          The unique identifier of the product.
     * @param string       $name        The name of the product.
     * @param bool         $inStock     Whether the product is in stock.
     * @param array        $gallery     The gallery of images for the product.
     * @param string       $description The description of the product.
     * @param BaseCategory $category    The category of the product.
     * @param string       $brand       The brand of the product.
     */
    public function __construct(
        string       $id,
        string       $name,
        bool         $inStock,
        array        $gallery,
        string       $description,
        BaseCategory $category,
        string       $brand
    ) {
        $this->id          = $id;
        $this->name        = $name;
        $this->inStock     = $inStock;
        $this->gallery     = $gallery;
        $this->description = $description;
        $this->category    = $category;
        $this->brand       = $brand;
    }

    /**
     * Get the unique identifier of the product.
     *
     * @return string The unique identifier of the product.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the name of the product.
     *
     * @return string The name of the product.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Check if the product is in stock.
     *
     * @return bool True if the product is in stock, false otherwise.
     */
    public function isInStock(): bool
    {
        return $this->inStock;
    }

    /**
     * Get the gallery of images for the product.
     *
     * @return array The gallery of images.
     */
    public function getGallery(): array
    {
        return $this->gallery;
    }

    /**
     * Add an image to the product's gallery.
     *
     * @param string $image The image to add.
     */
    public function addGalleryImage(string $image): void
    {
        $this->gallery[] = $image;
    }

    /**
     * Check if the product's gallery contains a specific image.
     *
     * @param string $image The image to check.
     * @return bool True if the image exists, false otherwise.
     */
    public function hasGalleryImage(string $image): bool
    {
        return in_array($image, $this->gallery, true);
    }

    /**
     * Get the description of the product.
     *
     * @return string|null The description of the product.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the category of the product.
     *
     * @return BaseCategory The category of the product.
     */
    public function getCategory(): BaseCategory
    {
        return $this->category;
    }

    /**
     * Get the brand of the product.
     *
     * @return string The brand of the product.
     */
    public function getBrand(): string
    {
        return $this->brand;
    }
}
