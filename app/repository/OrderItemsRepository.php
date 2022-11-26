<?php

namespace ECommerce\App\Repository;

use ECommerce\App\Entity\OrderItem;

class OrderItemsRepository extends BaseRepository {
    // List all order items for an order.
    public function list(string $orderID): array {
        $result = $this->query('SELECT * FROM order_items WHERE order_id = $1', [$orderID]);

        $items = [];

        while ($row = pg_fetch_assoc($result)) {
            $items[] = OrderItem::fromArray($row);
        }

        return $items;
    }

    // Save an order item in the database.
    public function save(OrderItem $orderItem): OrderItem {
        $q = <<<EOF
        insert into order_items (order_id, product_id, quantity, price)
        values ($1, $2, $3, $4)
        returning *
        EOF;
        $result = $this->query($q, [
            $orderItem->order_id,
            $orderItem->product_id,
            $orderItem->quantity,
            $orderItem->price
        ]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Failed to insert order item: ' . pg_last_error());
        }

        return OrderItem::fromArray($row);
    }
}
