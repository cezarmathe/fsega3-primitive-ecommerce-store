<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class CartItem implements Entity {
    public int $id;

    public int $cart_id;
    public int $product_id;

    public int $quantity;

    public static function fromArray(array $row, string $qualifier = ''): Entity {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $cartItem = new CartItem();

        $cartItem->id = $row[$qualifier . 'id'];

        $cartItem->cart_id = $row[$qualifier . 'cart_id'];
        $cartItem->product_id = $row[$qualifier . 'product_id'];

        $cartItem->quantity = $row[$qualifier . 'quantity'];

        return $cartItem;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'cart_id' => $this->cart_id,
            'product_id' => $this->product_id,

            'quantity' => $this->quantity,
        ];
    }
}
