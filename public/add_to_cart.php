<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\Entity\CartItem;
use ECommerce\App\Repository\CartItemsRepository;
use ECommerce\App\Repository\CartsRepository;
use ECommerce\App\Repository\UsersRepository;
use ECommerce\App\Service\CartService;
use ECommerce\App\Service\UsersService;

// If request method is not POST, redirect to the returnTo URL.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /index.php");
    exit;
}

// This indicates where we should return the user to once the form has been
// submitted successfully.
$returnTo = "/index.php";
if (isset($_POST['return_to'])) {
    $returnTo = $_POST['return_to'];
} else if (isset($_SERVER['HTTP_REFERER'])) {
    $returnTo = $_SERVER['HTTP_REFERER'];
}

// This indicates the product ID that we should add to the cart.
//
// If not set, we redirect the user back to the pre-computed returnTo URL.
if (!isset($_POST['product_id'])) {
    header("Location {$returnTo}");
    exit;
}
$productID = $_POST['product_id'];

session_start();

// Initialize repositories.

$userRepository = new UsersRepository();
$cartRepository = new CartsRepository();
$cartItemsRepository = new CartItemsRepository();

// Initialize services.

$cartsService = new CartService($cartRepository, $cartItemsRepository);
$userService = new UsersService($userRepository);

// Load the data and process the form.

$user = $userService->assert();
$cart = $cartsService->load($user);

$cartItem = new CartItem();
$cartItem->cart_id = $cart->id;
$cartItem->product_id = $productID;
$cartItem->quantity = 1;

// Insert the product into the cart.
$cartsService->create($cartItem);

header("Location: {$returnTo}");
exit();
