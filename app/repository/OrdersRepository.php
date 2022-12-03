<?php

namespace ECommerce\App\Repository;

use ECommerce\App\Entity\Order;

class OrdersRepository extends BaseRepository {
    // List the orders of an user.
    public function loadByUserID(string $userID) : array {
        $result = $this->query('select * from orders where user_id = $1', [$userID]);

        $orders = [];

        while ($row = pg_fetch_assoc($result)) {
            $orders[] = Order::fromArray($row);
        }

        return $orders;
    }

    // Find an order by ID.
    public function findByID(string $id): Order {
        $result = $this->query('select * from orders WHERE id = $1', [$id]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Order not found.');
        }

        return Order::fromArray($row);
    }

    // Save saves an order in the database.
    public function save(Order $order): Order {
        $cols = implode(', ', Order::columns());
        $q = <<<EOF
        insert into orders (cart_id, user_id)
        values ($1, $2)
        returning ${cols}
        EOF;
        $result = $this->query($q, [
            $order->cartID,
            $order->userID,
        ]);

        if (pg_affected_rows($result) != 1) {
            throw new \Exception('Failed to save order: ' . pg_last_error());
        }

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Failed to save order: ' . pg_last_error());
        }

        return Order::fromArray($row);
    }
}
