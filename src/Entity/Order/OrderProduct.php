<?php

declare(strict_types=1);

namespace App\Entity\Order;

use App\Entity\Product\Interface\ProductInterface;

/**
 * Represents a product in an order.
 *
 * @property ProductInterface    $product            The product associated with the order.
 * @property int                 $quantity           The quantity of the product in the order.
 * @property SelectedAttribute[] $selectedAttributes The selected attributes for the product.
 */
class OrderProduct
{
    /**
     * @var ProductInterface The product associated with the order.
     */
    private ProductInterface $product;

    /**
     * @var int The quantity of the product in the order.
     */
    private int $quantity;

    /**
     * @var SelectedAttribute[] The selected attributes for the product.
     */
    private array $selectedAttributes;

    /**
     * @param ProductInterface    $product            The product associated with the order.
     * @param int                 $quantity           The quantity of the product in the order.
     * @param SelectedAttribute[] $selectedAttributes The selected attributes for the product.
     */
    public function __construct(
        ProductInterface  $product,
        int               $quantity,
        array             $selectedAttributes
    ) {
        $this->product            = $product;
        $this->quantity           = $quantity;
        $this->selectedAttributes = $selectedAttributes;
    }

    /**
     * Get the product associated with the order.
     *
     * @return ProductInterface The product.
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    /**
     * Get the quantity of the product in the order.
     *
     * @return int The quantity of the product.
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Get the selected attributes for the product.
     *
     * @return SelectedAttribute[] The selected attributes.
     */
    public function getSelectedAttributes(): array
    {
        return $this->selectedAttributes;
    }

    /**
     * Add a selected attribute to the product.
     *
     * @param SelectedAttribute $selectedAttribute The selected attribute to add.
     */
    public function addSelectedAttribute(SelectedAttribute $selectedAttribute): void
    {
        $this->selectedAttributes[] = $selectedAttribute;
    }

    /**
     * Check if the product has a specific selected attribute.
     *
     * @param SelectedAttribute $selectedAttribute The selected attribute to check.
     * @return bool True if the attribute exists, false otherwise.
     */
    public function hasSelectedAttribute(SelectedAttribute $selectedAttribute): bool
    {
        foreach ($this->selectedAttributes as $attribute) {
            if ($attribute->getAttributeSetId() === $selectedAttribute->getAttributeSetId()) {
                return true;
            }
        }
        return false;
    }
}
