<?php

declare(strict_types=1);

namespace App\DTO\Response;

/**
 * Data Transfer Object for Place Order Response.
 *
 * @property string $orderNumber The unique order number.
 */
final class PlaceOrderResponseDTO
{
    /**
     * @var string The unique order number.
     */
    private string $orderNumber;

    /**
     * @param string $orderNumber The unique order number.
     */
    public function __construct(string $orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * Get the order number.
     *
     * @return string The unique order number.
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }
}
