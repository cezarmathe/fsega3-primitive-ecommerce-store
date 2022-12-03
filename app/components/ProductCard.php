<?php

namespace ECommerce\App\Components;

use ECommerce\App\Entity\Product;

class ProductCard implements Component {
    private Product $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function render(): string {
        $productContainerID = "product-{$this->product->id}";

        $html = <<<EOF
        <div class="card">
            <a href="/product.php?id={$this->product->id}">
                <img src="{$this->product->imageURL}" class="card-img-top" alt="...">
                <div id="{$productContainerID}" class="card-body">
                    <h5 class="card-title">{$this->product->name}</h5>
                    <p class="card-text">{$this->product->description}</p>
                    <p class="card-text">{$this->product->price}</p>
                    <form action="/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="{$this->product->id}">
                        <input type="hidden" name="return_to" value="{$_SERVER['REQUEST_URI']}#{$productContainerID}">
                        <button type="submit" class="btn btn-primary">Add to cart</button>
                    </form>
                </div>
            </a>
        </div>
        EOF;

        return $html;
    }
}
