<?php

namespace ECommerce\App;

use ECommerce\App\Repository\CartItemsRepository;
use ECommerce\App\Repository\CartsRepository;
use ECommerce\App\Repository\OrdersRepository;
use ECommerce\App\Repository\ProductsRepository;
use ECommerce\App\Repository\UsersRepository;
use ECommerce\App\Service\CartService;
use ECommerce\App\Service\OrderService;
use ECommerce\App\Service\UsersService;

class App {
    public CartItemsRepository $cartItemsRepository;
    public CartsRepository $cartsRepository;
    public OrdersRepository $ordersRepository;
    public ProductsRepository $productsRepository;
    public UsersRepository $usersRepository;

    public CartService $cartService;
    public OrderService $orderService;
    public UsersService $usersService;

    public function __construct() {
        $this->cartItemsRepository = new CartItemsRepository();
        $this->cartsRepository = new CartsRepository();
        $this->ordersRepository = new OrdersRepository();
        $this->productsRepository = new ProductsRepository();
        $this->usersRepository = new UsersRepository();

        $this->cartService = new CartService(
            $this->cartsRepository,
            $this->cartItemsRepository,
            $this->ordersRepository,
            $this->productsRepository,
        );
        $this->orderService = new OrderService(
            $this->ordersRepository,
            $this->cartService,
        );
        $this->usersService = new UsersService(
            $this->usersRepository
        );
    }
}
