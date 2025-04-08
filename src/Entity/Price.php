<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Currency\BaseCurrency;

/**
 * Represents a price with an amount and currency.
 *
 * @property float        $amount   The monetary amount.
 * @property BaseCurrency $currency The currency of the price.
 */
class Price
{
    /**
     * @var float The monetary amount.
     */
    private float $amount;

    /**
     * @var BaseCurrency The currency of the price.
     */
    private BaseCurrency $currency;

    /**
     * @param float        $amount   The monetary amount.
     * @param BaseCurrency $currency The currency of the price.
     */
    public function __construct(
        float $amount,
        BaseCurrency $currency
    ) {
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    /**
     * Get the monetary amount.
     *
     * @return float The monetary amount.
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Get the currency of the price.
     *
     * @return BaseCurrency The currency of the price.
     */
    public function getCurrency(): BaseCurrency
    {
        return $this->currency;
    }
}
