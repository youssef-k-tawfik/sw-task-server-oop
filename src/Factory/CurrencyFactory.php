<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Currency\Interface\CurrencyInterface;
use App\Entity\Currency\USD;

/**
 * Factory for creating currency instances.
 */
class CurrencyFactory
{
    /**
     * @var array<string, string> Mapping of currency labels to their corresponding classes.
     */
    private static array $currencyMap = [
        'USD' => USD::class,
    ];

    /**
     * Create a currency instance.
     *
     * @param string $currencyLabel The label of the currency (e.g., "USD").
     * @return CurrencyInterface         The created currency instance.
     * @throws \InvalidArgumentException If the currency label is unknown.
     */
    public static function create(string $currencyLabel): CurrencyInterface
    {
        $currencyLabel = strtoupper($currencyLabel);

        if (!isset(self::$currencyMap[$currencyLabel])) {
            throw new \InvalidArgumentException("Unknown currency label: {$currencyLabel}");
        }

        $currencyClass = self::$currencyMap[$currencyLabel];
        return new $currencyClass();
    }
}
