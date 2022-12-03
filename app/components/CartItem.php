<?php

namespace ECommerce\App\Components;

class CartItemList implements Component {
    private array $cartItems;

    function __construct($cartItems) {
        $this->cartItems = $cartItems;
    }

    function render(): string {
        $html = '';

        foreach ($this->cartItems as $cartItem) {
            $html .= $this->renderCartItem($cartItem);
        }

        return $html;
    }

    function renderCartItem($cartItem): string {
        $product = $cartItem->getProduct();
        $quantity = $cartItem->getQuantity();

        $html = <<<HTML
            <div class="cart-item">
                <div class="cart-item__image">
                    <img src="{$product->getImage()}" alt="{$product->getName()}">
                </div>
                <div class="cart-item__name">
                    {$product->getName()}
                </div>
                <div class="cart-item__quantity">
                    <input type="number" value="{$quantity}">
                </div>
                <div class="cart-item__price">
                    {$product->getPrice()} €
                </div>
                <div class="cart-item__remove">
                    <a href="/cart/remove/{$product->getId()}">Remove</a>
                </div>
            </div>
        HTML;

        return $html;
    }
}
