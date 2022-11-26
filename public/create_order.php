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

header("Location: {$returnTo}");
exit();
