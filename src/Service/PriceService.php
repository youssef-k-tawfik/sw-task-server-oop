<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Price;
use App\Factory\CurrencyFactory;
use App\Repository\PriceRepository;
use App\Utils\CustomLogger;

/**
 * Service for handling price-related operations.
 */
class PriceService
{
    /**
     * @var PriceRepository The repository for fetching prices.
     */
    private PriceRepository $priceRepository;

    /**
     * Constructor to initialize the PriceService.
     *
     * @param PriceRepository $priceRepository The repository for prices.
     */
    public function __construct(PriceRepository $priceRepository)
    {
        $this->priceRepository = $priceRepository;
    }

    /**
     * Fetch and process prices for a given product ID.
     *
     * @param string $productId The ID of the product to fetch prices for.
     * @return array            The processed list of prices.
     * @throws \Exception       If an error occurs while fetching prices.
     */
    public function getPrices(string $productId): array
    {
        try {
            $results = $this->priceRepository->getAllPrices($productId);
            $prices = $this->processPriceResults($results);

            CustomLogger::debug(__FILE__, __LINE__, $prices);
            return $prices;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching prices: {$e->getMessage()}");
        }
    }

    /**
     * Process raw price results into structured Price objects.
     *
     * @param array $results The raw price data from the repository.
     * @return array         The structured list of Price objects.
     */
    private function processPriceResults(array $results): array
    {
        $prices = [];

        foreach ($results as $row) {
            $price = new Price(
                (float)$row['amount'],
                CurrencyFactory::create($row['currency_label'])
            );
            $prices[] = $price;
        }

        return $prices;
    }
}
