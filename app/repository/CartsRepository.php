<?php

namespace ECommerce\App\Repository;

use ECommerce\App\Entity\Cart;
use ECommerce\App\Repository\BaseRepository;

class CartsRepository extends BaseRepository {
    // Insert a new cart for the user or return an existing one.
    public function upsert(string $userID): Cart {
        $cols= implode(', ', Cart::columns());
        $q = <<<EOF
        insert into carts (user_id)
        values ($1)
        on conflict (user_id) where ordered_at is null
        do update set updated_at = current_timestamp
        returning ${cols}
        EOF;

        $result = $this->query($q, [$userID]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Cart not found.');
        }

        return Cart::fromArray($row);
    }

    // Delete a cart by ID.
    public function delete(string $cartID) {
        $q = <<<EOF
        delete from carts
        where id = $1
        EOF;

        $result = $this->query($q, [$cartID]);

        if (pg_affected_rows($result) != 1) {
            throw new \Exception('Failed to delete cart.');
        }

        return;
    }

    public function findByID(string $cartID): Cart {
        $cols = implode(', ', Cart::columns());
        $q = <<<EOF
        select ${cols}
        from carts
        where id = $1
        EOF;

        $result = $this->query($q, [$cartID]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Cart not found.');
        }

        return Cart::fromArray($row);
    }

    public function checkout(Cart $cart): Cart {
        $cols = implode(', ', Cart::columns());
        $q = <<<EOF
        update carts
        set ordered_at = current_timestamp
        where id = $1
        returning ${cols}
        EOF;

        $result = $this->query($q, [$cart->id]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Failed to checkout cart.');
        }

        return Cart::fromArray($row);
    }
}
