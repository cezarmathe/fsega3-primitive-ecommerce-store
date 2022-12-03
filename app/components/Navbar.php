<?php

namespace ECommerce\App\Components;

use ECommerce\App\Components\Component;

use ECommerce\App\Entity\Cart;
use ECommerce\App\Entity\User;

class Navbar implements Component {
    private User $user;
    private Cart $cart;
    private int $cartItemsCount;

    public function __construct(User $user, Cart $cart, int $cartItemsCount) {
        $this->user = $user;
        $this->cart = $cart;
        $this->cartItemsCount = $cartItemsCount;
    }

    public function render(): string {
        $html = <<<EOF
        <nav class="navbar">
            <a href="/index.php" class="navbar-item">Home</a>
            <a href="/cart.php" class="navbar-item">Cart: {$this->cartItemsCount}</a>
            <a href="/orders.php " class="navbar-item">Orders</a>
            <a href="/logout.php" class="navbar-item">Logout</a>
        </nav>
        EOF;

        return $html;
    }
}
