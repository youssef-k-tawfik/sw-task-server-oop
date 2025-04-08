<?php

declare(strict_types=1);

namespace App\Entity\Currency;

/**
 * Base class for currencies.
 *
 * @property string $label  The label of the currency (e.g., "USD").
 * @property string $symbol The symbol of the currency (e.g., "$").
 */
abstract class BaseCurrency
{
    /**
     * @var string The label of the currency (e.g., "USD").
     */
    private string $label;

    /**
     * @var string The symbol of the currency (e.g., "$").
     */
    private string $symbol;

    /**
     * @param string $label  The label of the currency.
     * @param string $symbol The symbol of the currency.
     */
    public function __construct(
        string $label,
        string $symbol
    ) {
        $this->label  = $label;
        $this->symbol = $symbol;
    }

    /**
     * Get the label of the currency.
     *
     * @return string The label of the currency.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Get the symbol of the currency.
     *
     * @return string The symbol of the currency.
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
