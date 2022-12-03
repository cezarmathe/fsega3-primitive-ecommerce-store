<?php

namespace ECommerce\App\Service;

use ECommerce\App\Entity\Cart;
use ECommerce\App\Entity\CartItem;
use ECommerce\App\Entity\User;
use ECommerce\App\Repository\CartItemsRepository;
use ECommerce\App\Repository\CartsRepository;

class CartService {
    private CartsRepository $cartsRepository;
    private CartItemsRepository $cartItemsRepository;

    public function __construct(CartsRepository $cartsRepository, CartItemsRepository $cartItemsRepository) {
        $this->cartsRepository = $cartsRepository;
        $this->cartItemsRepository = $cartItemsRepository;
    }

    // Load the cart for the current user.
    public function load(User $user): Cart {
        return $this->cartsRepository->upsert($user->id);
    }

    // Load the items in the cart.
    public function loadItems(Cart $cart): array {
        $items = $this->cartItemsRepository->list($cart->id);

        foreach ($items as $item) {
            $item->cart = $cart;
        }

        return $items;
    }

    // Returns the number of items in the cart.
    public function countItems(Cart $cart): int {
        return $this->cartItemsRepository->count($cart->id);
    }

    // Insert a new cart item.
    public function create(CartItem $cartItem): void {
        $this->cartItemsRepository->upsert($cartItem);
    }
}
