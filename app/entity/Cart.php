<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class Cart implements Entity {
    public int $id;

    public int $userID;

    public static function fromArray(array $row, string $qualifier = ''): Cart {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $cart = new Cart();

        $cart->id = $row[$qualifier . 'id'];

        $cart->userID = $row[$qualifier . 'user_id'];

        return $cart;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'user_id' => $this->userID,
        ];
    }

    public static function columns(string $qualifier = ''): array {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        return [
            $qualifier . 'id',

            $qualifier . 'user_id',
        ];
    }
}
