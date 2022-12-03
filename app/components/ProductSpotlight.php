<?php

namespace ECommerce\App\Components;

use ECommerce\App\Components\Component;

class ProductSpotlight implements Component {
    private $product;

    public function __construct($product) {
        $this->product = $product;
    }

    public function render(): string {
        $product = $this->product;
        $product_id = $product->id;
        $name = $product->name;
        $description = $product->description;
        $price = $product->price;
        $image = $product->imageURL;

        return <<<EOF
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{$image}" class="img-fluid" alt="{$name}">
                </div>
                <div class="col-md-6">
                    <h1>{$name}</h1>
                    <p>{$description}</p>
                    <p class="lead">{$price}</p>
                    <form action="add_to_cart.php" method="post">
                        <input type="hidden" name="product_id" value="{$product_id}">
                        <button type="submit" class="btn btn-primary">Add to cart</button>
                    </form>
                </div>
            </div>
        </div>
        EOF;
    }
}
