<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver;

use App\DTO\Input\CartItemInputDTO;
use App\DTO\Input\SelectedAttributeInputDTO;
use App\DTO\Response\PlaceOrderResponseDTO;
use App\Service\OrderService;

/**
 * Resolver for handling orders in GraphQL.
 */
class OrderResolver
{
    /**
     * @var OrderService The service for managing orders.
     */
    private OrderService $orderService;

    /**
     * @param OrderService $orderService The service for managing orders.
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Map raw cart items input to DTOs.
     *
     * @param array $cartItems The raw cart items input.
     * @return CartItemInputDTO[] The mapped cart items as DTOs.
     */
    private function mapCartItemsInput(array $cartItems): array
    {
        return array_map(function ($item) {
            // Map selected attributes to DTOs.
            $selectedAttributes = array_map(function ($attr) {
                return new SelectedAttributeInputDTO(
                    $attr['attributeSetId'],
                    $attr['attributeId']
                );
            }, $item['selectedAttributes'] ?? []);

            // Return a new CartItemInputDTO for each cart item.
            return new CartItemInputDTO(
                $item['productId'],
                $item['quantity'],
                $selectedAttributes
            );
        }, $cartItems);
    }

    /**
     * Place an order.
     *
     * @param mixed $root The root object (not used in this resolver).
     * @param array $args The arguments for placing the order.
     * @return PlaceOrderResponseDTO The response DTO for the placed order.
     * @throws \Exception If an error occurs while placing the order.
     */
    public function placeOrder($root, $args): PlaceOrderResponseDTO
    {
        try {
            // Map cart items input to DTOs.
            $orderItemsInput = $this->mapCartItemsInput($args['cartItems']);

            return $this->orderService->placeOrder(
                $orderItemsInput,
                $args['currencyLabel']
            );
        } catch (\Exception $e) {
            throw new \Exception('An error occurred while placing the order: ' . $e->getMessage(),                 $e->getCode(), $e);
        }
    }

    /**
     * Get orders by their order numbers.
     *
     * @param mixed $root The root object (not used in this resolver).
     * @param array $args The arguments for fetching orders.
     * @return array The list of orders.
     * @throws \Exception If an error occurs while fetching the orders.
     */
    public function getOrders($root, $args): array
    {
        try {
            return $this->orderService->getOrders($args['orderNumbers']);
        } catch (\Exception $e) {
            throw new \Exception('An error occurred while resolving the orders: ' . $e->getMessage(),                 $e->getCode(), $e);
        }
    }
}
