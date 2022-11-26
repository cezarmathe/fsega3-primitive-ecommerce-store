<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\Entity\Cart;
use ECommerce\App\Repository\UsersRepository;
use ECommerce\App\Service\UsersService;
use ECommerce\App\Components\Head;
use ECommerce\App\Components\Html;
use ECommerce\App\Components\Navbar;
use ECommerce\App\Components\ProductsList;
use ECommerce\App\Repository\CartItemsRepository;
use ECommerce\App\Repository\CartsRepository;
use ECommerce\App\Repository\ProductsRepository;
use ECommerce\App\Service\CartService;

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

$products = $productsRepository->list();
$cart = $cartService->load($user);
$cartItemsCount = $cartService->countItems($cart);

// Build the page.

$head = new Head('Your cart');
$navbar = new Navbar($user, $cart, $cartItemsCount);

$html = new Html($head, $navbar, new ProductsList($products));

echo $html->render();
