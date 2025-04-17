<?php

declare(strict_types=1);

namespace App\Entity\Currency\Interface;

/**
 * Interface for currency entities.
 */
interface CurrencyInterface
{
    /**
     * Get the label of the currency.
     *
     * @return string The label of the currency (e.g., "USD").
     */
    public function getLabel(): string;

    /**
     * Get the symbol of the currency.
     *
     * @return string The symbol of the currency (e.g., "$").
     */
    public function getSymbol(): string;
}
