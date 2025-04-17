<?php

declare(strict_types=1);

namespace App\Entity\Product;

use App\Entity\Category\CategoryInterface;

/**
 * Base class for products.
 *
 * @property string            $id          The unique identifier of the product.
 * @property string            $name        The name of the product.
 * @property bool              $inStock     Whether the product is in stock.
 * @property array             $gallery     The gallery of images for the product.
 * @property string            $description The description of the product.
 * @property CategoryInterface $category    The category of the product.
 * @property string            $brand       The brand of the product.
 */
abstract class BaseProduct implements ProductInterface
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
     * @var CategoryInterface The category of the product.
     */
    protected CategoryInterface $category;

    /**
     * @var string The brand of the product.
     */
    protected string $brand;

    /**
     * @param string            $id          The unique identifier of the product.
     * @param string            $name        The name of the product.
     * @param bool              $inStock     Whether the product is in stock.
     * @param array             $gallery     The gallery of images for the product.
     * @param string            $description The description of the product.
     * @param CategoryInterface $category    The category of the product.
     * @param string            $brand       The brand of the product.
     */
    public function __construct(
        string            $id,
        string            $name,
        bool              $inStock,
        array             $gallery,
        string            $description,
        CategoryInterface $category,
        string            $brand
    ) {
        $this->id          = $id;
        $this->name        = $name;
        $this->inStock     = $inStock;
        $this->gallery     = $gallery;
        $this->description = $description;
        $this->category    = $category;
        $this->brand       = $brand;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isInStock(): bool
    {
        return $this->inStock;
    }

    public function getGallery(): array
    {
        return $this->gallery;
    }

    public function addGalleryImage(string $image): void
    {
        $this->gallery[] = $image;
    }

    public function hasGalleryImage(string $image): bool
    {
        return in_array($image, $this->gallery, true);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCategory(): CategoryInterface
    {
        return $this->category;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }
}
