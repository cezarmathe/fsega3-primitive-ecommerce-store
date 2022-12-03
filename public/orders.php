<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\App;
use ECommerce\App\Components\Head;
use ECommerce\App\Components\Html;
use ECommerce\App\Components\Navbar;
use ECommerce\App\Components\OrdersList;
use ECommerce\App\Components\OrderSpotlight;
use ECommerce\App\Repository\CartItemsRepository;
use ECommerce\App\Repository\CartsRepository;
use ECommerce\App\Repository\ProductsRepository;
use ECommerce\App\Repository\UsersRepository;
use ECommerce\App\Service\CartService;
use ECommerce\App\Service\UsersService;

session_start();

$app = new App();

// Load the data required for building the page.

$user = $app->usersService->assert();

$cart = $app->cartService->load($user);
$cartItemsCount = $app->cartService->countItems($cart);

// Get the order ID if there is one.
if (isset($_GET['id'])) {
    $orderID = $_GET['id'];
} else {
    $orderID = null;
}

$main = null;
$head = null;

if ($orderID) {
    $order = $app->orderService->findByID($orderID);

    $head = new Head("Order Details -- {$orderID}");
    $main = new OrderSpotlight($order);
} else {
    $head = new Head("Orders");
    $main = new OrdersList($app->orderService->list($user));
}

// Build the page.

$navbar = new Navbar($user, $cart, $cartItemsCount);

$html = new Html($head, $navbar, $main);

echo $html->render();
