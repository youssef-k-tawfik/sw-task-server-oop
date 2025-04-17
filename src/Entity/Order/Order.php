<?php

declare(strict_types=1);

namespace App\Entity\Order;

use App\Entity\Currency\Interface\CurrencyInterface;

/**
 * Represents an order entity.
 *
 * @property string            $orderNumber   The unique order number.
 * @property float             $totalAmount   The total amount of the order.
 * @property CurrencyInterface $currency      The currency used in the order.
 * @property \DateTime         $placedAt      The date and time when the order was placed.
 * @property OrderProduct[]    $products      The list of products in the order.
 */
class Order
{
    /**
     * @var string The unique order number.
     */
    private string $orderNumber;

    /**
     * @var float The total amount of the order.
     */
    private float $totalAmount;

    /**
     * @var CurrencyInterface The currency used in the order.
     */
    private CurrencyInterface $currency;

    /**
     * @var \DateTime The date and time when the order was placed.
     */
    private \DateTime $placedAt;

    /**
     * @var OrderProduct[] The list of products in the order.
     */
    private array $products = [];

    /**
     * @param string       $orderNumber  The unique order number.
     * @param float        $totalAmount  The total amount of the order.
     * @param CurrencyInterface $currency     The currency used in the order.
     * @param \DateTime    $placedAt     The date and time when the order was placed.
     */
    public function __construct(
        string $orderNumber,
        float $totalAmount,
        CurrencyInterface $currency,
        \DateTime $placedAt
    ) {
        $this->orderNumber = $orderNumber;
        $this->totalAmount = $totalAmount;
        $this->currency    = $currency;
        $this->placedAt    = $placedAt;
    }

    /**
     * Get the unique order number.
     *
     * @return string The unique order number.
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * Get the total amount of the order.
     *
     * @return float The total amount of the order.
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * Get the currency used in the order.
     *
     * @return CurrencyInterface The currency used in the order.
     */
    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
    }

    /**
     * Get the date and time when the order was placed.
     *
     * @return \DateTime The date and time of order placement.
     */
    public function getPlacedAt(): \DateTime
    {
        return $this->placedAt;
    }

    /**
     * Get the list of products in the order.
     *
     * @return OrderProduct[] The list of products.
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * Add a product to the order.
     *
     * @param OrderProduct $product The product to add.
     */
    public function addProduct(OrderProduct $product): void
    {
        $this->products[] = $product;
    }
}
