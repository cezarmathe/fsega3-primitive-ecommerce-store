<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class CartItem implements Entity {
    public int $id;

    public int $cartID;
    public Cart $cart;

    public int $productID;
    public Product $product;

    public int $quantity;

    public static function fromArray(array $row, string $qualifier = ''): Entity {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $cartItem = new CartItem();

        $cartItem->id = $row[$qualifier . 'id'];

        $cartItem->cartID = $row[$qualifier . 'cart_id'];
        $cartItem->productID = $row[$qualifier . 'product_id'];

        $cartItem->quantity = $row[$qualifier . 'quantity'];

        return $cartItem;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'cart_id' => $this->cartID,
            'product_id' => $this->productID,

            'quantity' => $this->quantity,
        ];
    }

    public static function columns(string $qualifier = ''): array {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        return [
            $qualifier . 'id',

            $qualifier . 'cart_id',
            $qualifier . 'product_id',

            $qualifier . 'quantity',
        ];
    }
}
