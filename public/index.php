<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\App;
use ECommerce\App\Components\AddProductForm;
use ECommerce\App\Components\AdminNavbar;
use ECommerce\App\Entity\Cart;
use ECommerce\App\Entity\User;
use ECommerce\App\Repository\UsersRepository;
use ECommerce\App\Service\UsersService;
use ECommerce\App\Components\Head;
use ECommerce\App\Components\Html;
use ECommerce\App\Components\Navbar;
use ECommerce\App\Components\ProductsList;
use ECommerce\App\Entity\Product;
use ECommerce\App\Repository\CartItemsRepository;
use ECommerce\App\Repository\CartsRepository;
use ECommerce\App\Repository\ProductsRepository;
use ECommerce\App\Service\CartService;

session_start();

$app = new App();

$user = $app->usersService->assert();

$products = $app->productsRepository->list();
$cart = $app->cartService->load($user);
$cartItemsCount = $app->cartService->countItems($cart);

// Build the page.

$head = null;
$main = null;
$navbar = null;

if ($user->isAdmin === true) {
    $head = new Head('Add product');
    $navbar = new AdminNavbar();
    $main = new AddProductForm();
} else {
    $head = new Head('Home');
    $navbar = new Navbar($user, $cart, $cartItemsCount);
    $main = new ProductsList($products);
}

$html = new Html($head, $navbar, $main);

echo $html->render();
