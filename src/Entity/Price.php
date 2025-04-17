<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Currency\CurrencyInterface;

/**
 * Represents a price with an amount and currency.
 *
 * @property float             $amount   The monetary amount.
 * @property CurrencyInterface $currency The currency of the price.
 */
class Price
{
    /**
     * @var float The monetary amount.
     */
    private float $amount;

    /**
     * @var CurrencyInterface The currency of the price.
     */
    private CurrencyInterface $currency;

    /**
     * @param float        $amount   The monetary amount.
     * @param CurrencyInterface $currency The currency of the price.
     */
    public function __construct(
        float $amount,
        CurrencyInterface $currency
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
     * @return CurrencyInterface The currency of the price.
     */
    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
    }
}
