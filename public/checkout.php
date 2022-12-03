<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\App;
use ECommerce\App\Entity\CartItem;

// If request method is not POST, redirect to the returnTo URL.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /index.php");
    exit;
}

if (!isset($_POST['cart_id'])) {
    header("Location /index.php");
    exit;
}
$cartID = $_POST['cart_id'];

session_start();

$app = new App();

// Load the data and process the form.

$user = $app->usersService->assert();
$cart = $app->cartService->findByID($cartID);

if ($cart->userID !== $user->id) {
    header("Location /index.php");
    exit;
}

$order = $app->cartService->checkout($cart);

header("Location: /orders.php?id={$order->id}");
exit();
