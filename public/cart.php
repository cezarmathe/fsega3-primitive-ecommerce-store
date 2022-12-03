<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\App;
use ECommerce\App\Components\CartView;
use ECommerce\App\Components\Head;
use ECommerce\App\Components\Html;
use ECommerce\App\Components\Navbar;

session_start();

$app = new App();

// Load the data required for building the page.

$user = $app->usersService->assert();

$cart = $app->cartService->load($user);
$cartItems = $app->cartService->loadItems($cart);
$cartItemsCount = $app->cartService->countItems($cart);

// Build the page.

$head = new Head('Your cart');
$navbar = new Navbar($user, $cart, $cartItemsCount);

$html = new Html($head, $navbar, new CartView($cart, $cartItems));

echo $html->render();
