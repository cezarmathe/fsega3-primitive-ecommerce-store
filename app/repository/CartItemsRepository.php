<?php

namespace ECommerce\App\Repository;

use ECommerce\App\Entity\Cart;
use ECommerce\App\Entity\CartItem;
use ECommerce\App\Repository\BaseRepository;

class CartItemsRepository extends BaseRepository {
    // Inserts a new cart item or updates an existing one.
    public function upsert(CartItem $cartItem): CartItem {
        $q = <<<EOF
        insert into cart_items (cart_id, product_id, quantity)
        values ($1, $2, $3)
        on conflict (cart_id, product_id) do update
        set quantity = cart_items.quantity + EXCLUDED.quantity
        returning *
        EOF;
        $result = $this->query($q, [
            $cartItem->cart_id,
            $cartItem->product_id,
            $cartItem->quantity
        ]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Failed to insert cart item: ' . pg_last_error());
        }

        return CartItem::fromArray($row);
    }

    // List all cart items for a cart.
    public function list(string $cartID): array {
        $result = $this->query('select * from cart_items where cart_id = $1', [$cartID]);

        $items = [];

        while ($row = pg_fetch_assoc($result)) {
            $items[] = CartItem::fromArray($row);
        }

        return $items;
    }

    // Returns the number of items in the cart.
    public function count(string $cartID): int {
        $result = $this->query('select count(*) from cart_items where cart_id = $1', [$cartID]);

        $row = pg_fetch_row($result);
        if (!$row) {
            throw new \Exception('Failed to count cart items: ' . pg_last_error());
        }

        return (int) $row[0];
    }
}
