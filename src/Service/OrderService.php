<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Response\PlaceOrderResponseDTO;
use App\Validator\OrderInputValidator;
use App\Repository\OrderRepository;
use App\Entity\Order\Order;
use App\Entity\Order\OrderProduct;
use App\Entity\Order\SelectedAttribute;
use App\Factory\ProductFactory;
use App\Utils\CustomLogger;

/**
 * Service for handling order-related operations.
 */
class OrderService
{
    /**
     * @var OrderRepository The repository for order-related database operations.
     */
    private OrderRepository $orderRepository;

    /**
     * @var PriceService The service for handling price-related operations.
     */
    private PriceService $priceService;

    /**
     * Constructor to initialize the OrderService.
     *
     * @param OrderRepository $orderRepository The repository for orders.
     * @param PriceService    $priceService    The service for prices.
     */
    public function __construct(
        OrderRepository $orderRepository,
        PriceService $priceService
    ) {
        $this->orderRepository = $orderRepository;
        $this->priceService = $priceService;
    }

    /**
     * Validates input, calculates the total amount, generates an order number,
     * manages the transaction, and inserts the order.
     *
     * @param array  $cartItemsInput Array of cart items input objects.
     * @param string $currencyLabel  The currency label for the order.
     * @return PlaceOrderResponseDTO The response DTO containing the order number.
     * @throws \Exception            If an error occurs during processing.
     */
    public function placeOrder(
        array $cartItemsInput,
        string $currencyLabel
    ): PlaceOrderResponseDTO {
        try {
            // Validate input data
            OrderInputValidator::validateCartItems($cartItemsInput);
            OrderInputValidator::validateCurrencyLabel($currencyLabel);

            // Calculate total amount
            $totalAmount = $this->calculateTotalAmount(
                $cartItemsInput,
                $currencyLabel
            );

            // Generate a unique order number
            $orderNumber = date('Ymd') . uniqid();

            // Begin transaction
            $this->orderRepository->beginTransaction();
            $orderId = $this->orderRepository->insertOrderRecord(
                $orderNumber,
                $totalAmount,
                $currencyLabel
            );
            $this->orderRepository->insertOrderProducts($orderId, $cartItemsInput);
            $this->orderRepository->commit();

            return new PlaceOrderResponseDTO($orderNumber);
        } catch (\Exception $e) {
            $this->orderRepository->rollBack();
            throw new \Exception("Error placing order: " . $e->getMessage());
        }
    }

    /**
     * Retrieves orders by order numbers and processes raw data into domain objects.
     *
     * @param array $orderNumbers Array of order numbers.
     * @return array              Processed order objects.
     * @throws \Exception         If an error occurs during retrieval.
     */
    public function getOrders(array $orderNumbers): array
    {
        try {
            $results = $this->orderRepository->fetchOrderData($orderNumbers);
            return $this->processOrderResults($results);
        } catch (\Exception $e) {
            throw new \Exception("Error retrieving orders: " . $e->getMessage());
        }
    }

    /**
     * Calculates the total order amount using pricing data.
     *
     * @param array  $orderItems    Array of order items.
     * @param string $currencyLabel Currency label.
     * @return float                The total calculated amount.
     * @throws \Exception           If a valid price is not found.
     */
    private function calculateTotalAmount(
        array $orderItems,
        string $currencyLabel
    ): float {
        $totalAmount = 0;
        foreach ($orderItems as $item) {
            $prices = $this->priceService->getPrices($item->getProductId());
            $filteredPrices = array_filter(
                $prices,
                fn($p) => $p->getCurrency()->getLabel() === $currencyLabel
            );
            if (empty($filteredPrices)) {
                throw new \Exception("Invalid price for product ID: {$item->getProductId()} in currency: {$currencyLabel}");
            }
            $itemPrice = reset($filteredPrices)->getAmount();
            $totalAmount += $itemPrice * $item->getQuantity();
        }
        return round($totalAmount, 2);
    }

    /**
     * Transforms raw order query results into domain objects.
     *
     * @param array $results Raw data from the database.
     * @return array         Processed Order objects.
     */
    private function processOrderResults(array $results): array
    {
        $orders = [];
        foreach ($results as $row) {
            $orderNumber = $row['order_number'];

            if (!isset($orders[$orderNumber])) {
                $orders[$orderNumber] = $this->createOrder($row);
            }

            $order = $orders[$orderNumber];
            $this->processOrderProduct($order, $row);
        }

        CustomLogger::debug(__FILE__, __LINE__, $orders);
        return array_values($orders);
    }

    /**
     * Creates an Order domain object from a row of data.
     *
     * @param array $row Raw data for a single order.
     * @return Order     The created Order object.
     */
    private function createOrder(array $row): Order
    {
        return new Order(
            $row['order_number'],
            (float)$row['total_amount'],
            $row['currency_label'],
            new \DateTime($row['placed_at'])
        );
    }

    /**
     * Processes a single row into its corresponding OrderProduct and attaches it to the order.
     *
     * @param Order $order The order being processed.
     * @param array $row   A single row of raw order data.
     */
    private function processOrderProduct(
        Order $order,
        array $row
    ): void {
        $productId = $row['product_id'];
        $existingProduct = array_filter(
            $order->getProducts(),
            fn(OrderProduct $product) => $product->getProduct()->getId() === $productId
        );

        if (empty($existingProduct)) {
            $orderProduct = $this->createOrderProduct($row);
            $order->addProduct($orderProduct);
        } else {
            $orderProduct = reset($existingProduct);
        }

        $this->addGalleryImage($orderProduct, $row['gallery_url']);
        $this->addSelectedAttributes($orderProduct, $row);
    }

    /**
     * Creates an OrderProduct domain object from a row of data.
     *
     * @param array $row Raw data for a product.
     * @return OrderProduct The created OrderProduct object.
     */
    private function createOrderProduct(array $row): OrderProduct
    {
        $product = ProductFactory::create(
            $row['product_id'],
            $row['product_name'],
            (bool)$row['in_stock'],
            [$row['gallery_url']],
            $row['description'],
            $row['category_name'],
            $row['brand_name']
        );

        return new OrderProduct(
            $product,
            (int)$row['quantity'],
            []
        );
    }

    /**
     * Adds a gallery image to the OrderProduct if not already present.
     *
     * @param OrderProduct $orderProduct The product being processed.
     * @param string|null  $galleryUrl   The URL of the gallery image.
     */
    private function addGalleryImage(
        OrderProduct $orderProduct,
        ?string $galleryUrl
    ): void {
        if ($galleryUrl) {
            $product = $orderProduct->getProduct();
            if (!$product->hasGalleryImage($galleryUrl)) {
                $product->addGalleryImage($galleryUrl);
            }
        }
    }

    /**
     * Adds selected attributes to the OrderProduct if provided.
     *
     * @param OrderProduct $orderProduct The product being processed.
     * @param array        $row          Raw data containing attribute information.
     */
    private function addSelectedAttributes(
        OrderProduct $orderProduct,
        array $row
    ): void {
        if (!empty($row['attribute_id']) && !empty($row['attribute_set_id'])) {
            $selectedAttribute = new SelectedAttribute(
                $row['attribute_set_id'],
                $row['attribute_id']
            );

            if (!$orderProduct->hasSelectedAttribute($selectedAttribute)) {
                $orderProduct->addSelectedAttribute($selectedAttribute);
            }
        }
    }
}
