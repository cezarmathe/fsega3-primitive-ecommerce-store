<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class Order implements Entity {
    public string $id;

    public string $userID;
    public string $cartID;
    public Cart $cart;

    public static function fromArray(array $row, string $qualifier = ''): Order {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $order = new Order();

        $order->id = $row[$qualifier . 'id'];

        $order->userID= $row[$qualifier . 'user_id'];
        $order->cartID = $row[$qualifier . 'cart_id'];

        return $order;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'user_id' => $this->userID,
            'cart_id' => $this->cartID,
        ];
    }

    public static function columns(string $qualifier = ''): array {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        return [
            $qualifier . 'id',

            $qualifier . 'user_id',
            $qualifier . 'cart_id',
        ];
    }
}
