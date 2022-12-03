<?php

namespace ECommerce\App\Components;

use ECommerce\App\Entity\Cart;
use ECommerce\App\Entity\CartItem;

class CartView implements Component {
    private Cart $cart;
    private array $items;

    public function __construct(Cart $cart, array $items) {
        $this->cart = $cart;
        $this->items = $items;
    }

    public function render(): string {
        $cartTotal = 0;

        $html = '<h1>Cart</h1>';
        $html .= '<table>';
        $html .= '<tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>';
        foreach ($this->items as $item) {
            $total = $item->quantity * $item->product->price;

            $cartTotal += $total;

            $html .= '<tr>';
            $html .= '<td>' . $item->product->name . '</td>';
            $html .= '<td>' . $item->quantity . '</td>';
            $html .= '<td>' . $item->product->price . '</td>';
            $html .= '<td>' . $total . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '<p>Total: ' . $cartTotal . '</p>';
        $html .= <<<EOF
        <form action="/checkout.php" method="POST">
            <input type="hidden" name="cart_id" value="{$this->cart->id}">
            <button type="submit" class="btn btn-primary">Checkout</button>
        </form>
        EOF;
        return $html;
    }
}
