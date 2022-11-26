<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class OrderItem implements Entity {
    public int $id;

    public int $order_id;
    public int $product_id;

    public int $quantity;

    public static function fromArray(array $row, string $qualifier = ''): OrderItem {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $orderItem = new OrderItem();

        $orderItem->id = $row[$qualifier . 'id'];

        $orderItem->order_id = $row[$qualifier . 'order_id'];
        $orderItem->product_id = $row[$qualifier . 'product_id'];

        $orderItem->quantity = $row[$qualifier . 'quantity'];

        return $orderItem;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'order_id' => $this->order_id,
            'product_id' => $this->product_id,

            'quantity' => $this->quantity,
        ];
    }
}
