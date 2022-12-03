<?php

namespace ECommerce\App\Service;

use ECommerce\App\Entity\Cart;
use ECommerce\App\Entity\CartItem;
use ECommerce\App\Entity\Order;
use ECommerce\App\Entity\User;
use ECommerce\App\Repository\CartItemsRepository;
use ECommerce\App\Repository\CartsRepository;
use ECommerce\App\Repository\OrdersRepository;
use ECommerce\App\Repository\ProductsRepository;

class CartService {
    private CartsRepository $cartsRepository;
    private CartItemsRepository $cartItemsRepository;
    private OrdersRepository $ordersRepository;
    private ProductsRepository $productsRepository;

    public function __construct(
        CartsRepository $cartsRepository,
        CartItemsRepository $cartItemsRepository,
        OrdersRepository $ordersRepository,
        ProductsRepository $productsRepository) {
        $this->cartsRepository = $cartsRepository;
        $this->cartItemsRepository = $cartItemsRepository;
        $this->ordersRepository = $ordersRepository;
        $this->productsRepository = $productsRepository;
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
            $item->product = $this->productsRepository->findByID($item->productID);
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

    public function findByID(string $cartID): Cart {
        return $this->cartsRepository->findByID($cartID);
    }

    // Checkout creates a new order with the cart id and sets the ordered at
    // date at the current timestamp on the cart.
    public function checkout(Cart $cart): Order {
        $cart = $this->cartsRepository->checkout($cart);
        $order = new Order();
        $order->userID = $cart->userID;
        $order->cartID = $cart->id;
        return $this->ordersRepository->save($order);
    }
}
