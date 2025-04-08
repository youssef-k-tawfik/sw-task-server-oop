<?php

declare(strict_types=1);

namespace App\DTO\Input;

/**
 * Data Transfer Object for Cart Item Input.
 *
 * @property string $productId          The ID of the product.
 * @property int    $quantity           The quantity of the product.
 * @property array  $selectedAttributes The selected attributes for the product.
 */
final class CartItemInputDTO
{
    /**
     * @var string The ID of the product.
     */
    private string $productId;

    /**
     * @var int The quantity of the product.
     */
    private int $quantity;

    /**
     * @var array The selected attributes for the product.
     */
    private array $selectedAttributes;

    /**
     * @param string $productId          The ID of the product.
     * @param int    $quantity           The quantity of the product.
     * @param array  $selectedAttributes The selected attributes for the product.
     */
    public function __construct(
        string $productId,
        int    $quantity,
        array  $selectedAttributes
    ) {
        $this->productId          = $productId;
        $this->quantity           = $quantity;
        $this->selectedAttributes = $selectedAttributes;
    }

    /**
     * Get the product ID.
     *
     * @return string The ID of the product.
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * Get the quantity of the product.
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
     * @return array The selected attributes.
     */
    public function getSelectedAttributes(): array
    {
        return $this->selectedAttributes;
    }
}
