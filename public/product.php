<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\App;
use ECommerce\App\Components\ProductSpotlight;
use ECommerce\App\Components\Head;
use ECommerce\App\Components\Html;
use ECommerce\App\Components\Navbar;

session_start();

$app = new App();

$user = $app->usersService->assert();

$cart = $app->cartService->load($user);
$cartItems = $app->cartService->loadItems($cart);
$cartItemsCount = $app->cartService->countItems($cart);

$product_id = $_GET['id'] ?? null;
if ($product_id === null) {
    $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header("Location: $referer");
    exit;
}

$product = $app->productsRepository->findByID($product_id);

// Build the page.

$head = new Head($product->name);
$navbar = new Navbar($user, $cart, $cartItemsCount);
$main = new ProductSpotlight($product);

$html = new Html($head, $navbar, $main);

echo $html->render();
