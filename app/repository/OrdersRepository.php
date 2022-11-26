<?php

namespace ECommerce\App\Repository;

use ECommerce\App\Entity\Order;

class OrdersRepository extends BaseRepository {
    // List the orders of an users.
    public function list(string $userID) : array {
        $result = $this->query('select * from orders WHERE user_id = $1', [$userID]);

        $orders = [];

        while ($row = pg_fetch_assoc($result)) {
            $orders[] = Order::fromArray($row);
        }

        return $orders;
    }

    // Find an order by ID.
    public function findByID(string $id) : Order {
        $result = $this->query('select * from orders WHERE id = $1', [$id]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Order not found.');
        }

        return Order::fromArray($row);
    }

    // Save saves an order in the database.
    public function save(Order $order) {
        $q = <<<EOF
        insert into orders (cart_id, user_id, total)
        values ($1, $2, $3)
        EOF;
        $result = $this->query($q, [
            $order->cart_id,
            $order->user_id,
            $order->total
        ]);

        if (pg_affected_rows($result) != 1) {
            throw new \Exception('Failed to save order: ' . pg_last_error());
        }

        return;
    }
}
