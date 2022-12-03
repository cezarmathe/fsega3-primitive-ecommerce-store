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

class OrderService {
    private OrdersRepository $ordersRepository;
    private CartService $cartService;

    public function __construct(
        OrdersRepository $ordersRepository,
        CartService $cartService) {
        $this->ordersRepository = $ordersRepository;
        $this->cartService = $cartService;
    }

    public function list(User $user): array {
        $list = $this->ordersRepository->loadByUserID($user->id);

        $fullList = [];
        // load carts for each order
        foreach ($list as $order) {
            $fullList[] = $this->findByID($order->id);
        }

        return $fullList;
    }

    public function findByID(string $id): Order {
        $order = $this->ordersRepository->findByID($id);
        $order->cart = $this->cartService->findByID($order->cartID);

        return $order;
    }
}
