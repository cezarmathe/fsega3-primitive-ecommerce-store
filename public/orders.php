<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\Components\Head;
use ECommerce\App\Components\Html;
use ECommerce\App\Components\Navbar;
use ECommerce\App\Components\OrdersList;
use ECommerce\App\Repository\CartItemsRepository;
use ECommerce\App\Repository\CartsRepository;
use ECommerce\App\Repository\ProductsRepository;
use ECommerce\App\Repository\UsersRepository;
use ECommerce\App\Service\CartService;
use ECommerce\App\Service\UsersService;

session_start();

// Initialize repositories.

$cartItemsRepository = new CartItemsRepository();
$cartsRepository = new CartsRepository();
$productsRepository = new ProductsRepository();
$userRepository = new UsersRepository();

// Initialize services.

$cartService = new CartService($cartsRepository, $cartItemsRepository);
$userService = new UsersService($userRepository);

// Load the data required for building the page.

$user = $userService->assert();

$cart = $cartService->load($user);
$cartItemsCount = $cartService->countItems($cart);

// Get the order ID if there is one.
if (isset($_GET['id'])) {
    $orderID = $_GET['id'];
} else {
    $orderID = null;
}

$mainComponent = null;

if ($orderID) {
    $order = $cartService->loadOrder($orderID);
    $mainComponent = new OrdersList([$order]);
} else {
    $orders = $cartService->loadOrders($user);
    $mainComponent = new OrdersList($orders);
}

// Build the page.

$head = new Head('Home');
$navbar = new Navbar($user, $cart, $cartItemsCount);
$ordersList = new OrdersList([]);

$html = new Html($head, $navbar, $ordersList);

echo $html->render();
