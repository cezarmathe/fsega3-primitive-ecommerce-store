<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class Order implements Entity {
    public $id;

    public $user_id;

    public static function fromArray(array $row, string $qualifier = ''): Order {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $order = new Order();

        $order->id = $row[$qualifier . 'id'];

        $order->user_id = $row[$qualifier . 'user_id'];

        return $order;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'user_id' => $this->user_id,
        ];
    }
}
