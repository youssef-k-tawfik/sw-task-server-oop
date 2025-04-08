<?php

declare(strict_types=1);

namespace App\Validator;

use App\DTO\Input\CartItemInputDTO;
use App\DTO\Input\SelectedAttributeInputDTO;

/**
 * Validator class for validating order input data.
 * 
 * This class provides methods to validate cart items and currency labels
 * to ensure the input data meets the required criteria.
 */
class OrderInputValidator
{
    /**
     * Validates an array of cart items.
     *
     * Each cart item must be an instance of CartItemInputDTO, have a non-empty product ID,
     * and a quantity greater than zero. Additionally, each selected attribute within the
     * cart item must be an instance of SelectedAttributeInputDTO and have valid IDs.
     *
     * @param CartItemInputDTO[] $cartItemsInput Array of cart items to validate.
     * @throws \InvalidArgumentException If any validation rule is violated.
     * @return void
     */
    public static function validateCartItems(array $cartItemsInput): void
    {
        foreach ($cartItemsInput as $cartItem) {
            if (!$cartItem instanceof CartItemInputDTO) {
                throw new \InvalidArgumentException('Invalid cart item input.');
            }

            if (empty($cartItem->getProductId())) {
                throw new \InvalidArgumentException('Product ID cannot be empty.');
            }

            if ($cartItem->getQuantity() <= 0) {
                throw new \InvalidArgumentException('Quantity must be greater than zero.');
            }

            foreach ($cartItem->getSelectedAttributes() as $attribute) {
                if (!$attribute instanceof SelectedAttributeInputDTO) {
                    throw new \InvalidArgumentException('Selected attribute must be an instance of SelectedAttributeInputDTO.');
                }

                if (empty($attribute->getAttributeId()) || empty($attribute->getAttributeSetId())) {
                    throw new \InvalidArgumentException('Selected attributes must have valid IDs.');
                }
            }
        }
    }

    /**
     * Validates the currency label.
     *
     * The currency label must not be empty.
     *
     * @param string $currencyLabel The currency label to validate.
     * @throws \InvalidArgumentException If the currency label is empty.
     * @return void
     */
    public static function validateCurrencyLabel(string $currencyLabel): void
    {
        if (empty($currencyLabel)) {
            throw new \InvalidArgumentException('Currency label cannot be empty.');
        }
    }
}
