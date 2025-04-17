<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Base\BaseRepository;

/**
 * Repository for handling order-related database operations.
 */
class OrderRepository extends BaseRepository
{
    /**
     * Insert a new order record into the database.
     *
     * @param string $orderNumber   The unique order number.
     * @param float  $totalAmount   The total amount of the order.
     * @param string $currencyLabel The label of the currency used in the order.
     * @return int                  The ID of the newly inserted order.
     */
    public function insertOrderRecord(
        string $orderNumber,
        float $totalAmount,
        string $currencyLabel
    ): int {
        $query = "
        INSERT INTO orders (order_number, total_amount, currency_id) 
        VALUES (:order_number, :total_amount, 
        (SELECT id FROM currency WHERE label = :currency_label))";

        $stmt = $this->connection->prepare($query);
        $stmt->execute([
            ':order_number'   => $orderNumber,
            ':total_amount'   => $totalAmount,
            ':currency_label' => $currencyLabel
        ]);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * Insert order products and their selected attributes into the database.
     *
     * @param int   $orderId    The ID of the order.
     * @param array $orderItems The list of order items, including products and attributes.
     */
    public function insertOrderProducts(
        int $orderId,
        array $orderItems
    ): void {
        $orderProductQuery = "
        INSERT INTO order_products (order_id, product_id, quantity) 
        VALUES (:order_id, :product_id, :quantity)";
        $orderProductStmt = $this->connection->prepare($orderProductQuery);

        $orderProductAttributesQuery = "
        INSERT INTO order_product_attributes (order_product_id, attribute_id, attribute_set_id) 
        VALUES (:order_product_id, :attribute_id, :attribute_set_id)";
        $orderProductAttributesStmt = $this->connection->prepare($orderProductAttributesQuery);

        // for each order item, insert into order_products
        foreach ($orderItems as $item) {
            $orderProductStmt->execute([
                ':order_id'   => $orderId,
                ':product_id' => $item->getProductId(),
                ':quantity'   => $item->getQuantity()
            ]);

            // for each selected attribute, insert into order_product_attributes
            $orderProductId = (int)$this->connection->lastInsertId();
            foreach ($item->getSelectedAttributes() as $selectedAttribute) {
                $orderProductAttributesStmt->execute([
                    ':order_product_id' => $orderProductId,
                    ':attribute_id'     => $selectedAttribute->getAttributeId(),
                    ':attribute_set_id' => $selectedAttribute->getAttributeSetId()
                ]);
            }
        }
    }

    private function validateOrderNumbers(array $orderNumbers): void
    {
        foreach ($orderNumbers as $orderNumber) {
            if (!is_string($orderNumber) || !preg_match('/^\d{8}[a-f0-9]{13}$/', $orderNumber)) {
                throw new \InvalidArgumentException('order numbers are not valid');
            }
        }
    }

    /**
     * Fetch order data based on an array of order numbers.
     *
     * @param array $orderNumbers The list of order numbers to fetch data for.
     * @return array              The fetched order data as an array.
     */
    public function fetchOrderData(array $orderNumbers): array
    {
        if (empty($orderNumbers)) {
            return [];
        }

        $this->validateOrderNumbers($orderNumbers);

        // Prepare placeholders for the SQL query based on the number of order numbers
        $placeholders = rtrim(str_repeat('?,', count($orderNumbers)), ',');

        $query = "
        SELECT 
            o.id AS order_id,
            o.order_number,
            o.total_amount,
            o.placed_at,
            curr.label AS currency_label,
            p.id AS product_id,
            p.name AS product_name,
            p.in_stock,
            p.description,
            cat.name AS category_name,
            b.name AS brand_name,
            g.url AS gallery_url,
            op.quantity,
            opa.attribute_id,
            opa.attribute_set_id
        FROM orders o
        LEFT JOIN currency curr ON o.currency_id = curr.id
        LEFT JOIN order_products op ON o.id = op.order_id
        LEFT JOIN product p ON op.product_id = p.id
        LEFT JOIN category cat ON p.category_id = cat.id
        LEFT JOIN brand b ON p.brand_id = b.id
        LEFT JOIN gallery g ON p.id = g.product_id
        LEFT JOIN order_product_attributes opa ON op.id = opa.order_product_id
        WHERE o.order_number IN ($placeholders)
        ";

        $stmt = $this->connection->prepare($query);
        $stmt->execute($orderNumbers);
        return $stmt->fetchAll();
    }
}
