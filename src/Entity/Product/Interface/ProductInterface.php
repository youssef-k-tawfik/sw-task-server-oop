<?php

declare(strict_types=1);

namespace App\Entity\Product\Interface;

use App\Entity\Category\Interface\CategoryInterface;

/**
 * Interface for product entities.
 */
interface ProductInterface
{
    /**
     * Get the unique identifier of the product.
     *
     * @return string The unique identifier of the product.
     */
    public function getId(): string;

    /**
     * Get the name of the product.
     *
     * @return string The name of the product.
     */
    public function getName(): string;

    /**
     * Check if the product is in stock.
     *
     * @return bool True if the product is in stock, false otherwise.
     */
    public function isInStock(): bool;

    /**
     * Get the gallery of images for the product.
     *
     * @return array The gallery of images.
     */
    public function getGallery(): array;

    /**
     * Add an image to the product's gallery.
     *
     * @param string $image The image to add.
     */
    public function addGalleryImage(string $image): void;

    /**
     * Check if the product's gallery contains a specific image.
     *
     * @param string $image The image to check.
     * @return bool True if the image exists, false otherwise.
     */
    public function hasGalleryImage(string $image): bool;

    /**
     * Get the description of the product.
     *
     * @return string|null The description of the product.
     */
    public function getDescription(): ?string;

    /**
     * Get the category of the product.
     *
     * @return CategoryInterface The category of the product.
     */
    public function getCategory(): CategoryInterface;

    /**
     * Get the brand of the product.
     *
     * @return string The brand of the product.
     */
    public function getBrand(): string;
}
