<?php

declare(strict_types=1);

namespace App\Entity\Currency;

/**
 * Represents the United States Dollar (USD) currency.
 */
final class USD extends BaseCurrency
{
    /**
     * @var string The label of the USD currency.
     */
    private const LABEL  = 'USD';

    /**
     * @var string The symbol of the USD currency.
     */
    private const SYMBOL = '$';

    /**
     * Initializes the USD currency.
     */
    public function __construct()
    {
        parent::__construct(self::LABEL, self::SYMBOL);
    }
}
