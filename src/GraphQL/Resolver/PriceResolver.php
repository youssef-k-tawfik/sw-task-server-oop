<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver;

use App\Service\PriceService;

/**
 * Resolver for handling price-related GraphQL queries.
 */
class PriceResolver
{
    /**
     * @var PriceService Service for handling price-related operations.
     */
    private PriceService $priceService;

    /**
     * Constructor to initialize the PriceResolver with a PriceService instance.
     *
     * @param PriceService $priceService The service used for fetching prices.
     */
    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * Retrieves all prices for a given product.
     *
     * @param object $root The root object containing the product ID.
     * @return array The list of prices for the product.
     * @throws \Exception If an error occurs while resolving prices.
     */
    public function getAllPrices($root): array
    {
        try {
            $productID = $root->getId() ?? null;
            $prices = $this->priceService->getPrices($productID);
            return $prices;
        } catch (\Exception $e) {
            throw new \Exception("Error resolving prices: {$e->getMessage()}");
        }
    }
}
