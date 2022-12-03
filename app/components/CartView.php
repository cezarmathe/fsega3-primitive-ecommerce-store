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
        $html = '<h1>Cart</h1>';
        $html .= '<table>';
        $html .= '<tr><th>Product</th><th>Quantity</th><th>Price</th></tr>';
        foreach ($this->items as $item) {
            $html .= '<tr>';
            $html .= '<td>' . $item->product->name . '</td>';
            $html .= '<td>' . $item->quantity . '</td>';
            $html .= '<td>' . $item->product->price . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '<p>Total: ' . $this->cart->total . '</p>';
        $html .= '<a href="/cart/checkout">Checkout</a>';
        return $html;
    }
}
