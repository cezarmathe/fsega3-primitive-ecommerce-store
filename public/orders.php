<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\Entity\Cart;
use ECommerce\App\Repository\UsersRepository;
use ECommerce\App\Service\UsersService;
use ECommerce\App\Components\Head;
use ECommerce\App\Components\Navbar;

session_start();

$repository = new UsersRepository();
$userService = new UsersService($repository);

$user = $userService->assert();

// load products
// load cart

$cart = new Cart();

$head = new Head('Home');
$navbar = new Navbar($user, $cart);

?>

<html>
    <?php echo $head->render() ?>

    <body>
        <div class="app">
            <?php echo $navbar->render() ?>

            <h1>Your cart</h1>
        </div>
    </body>
</html>
