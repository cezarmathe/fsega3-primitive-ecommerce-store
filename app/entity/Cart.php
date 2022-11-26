<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class Cart implements Entity {
    public int $id;

    public int $user_id;

    public static function fromArray(array $row, string $qualifier = ''): Cart {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $cart = new Cart();

        $cart->id = $row[$qualifier . 'id'];

        $cart->user_id = $row[$qualifier . 'user_id'];

        return $cart;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'user_id' => $this->user_id,
        ];
    }
}
