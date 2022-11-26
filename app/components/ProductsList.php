<?php

namespace ECommerce\App\Components;

class ProductsList implements Component {
    private array $products;

    public function __construct(array $products) {
        $this->products = $products;
    }

    public function render(): string {
        $html = <<<EOF
        <div class="row">
            <div class="col-md-12">
                <h1>Products</h1>
                <ul>
        EOF;

        foreach ($this->products as $product) {
            $html .= (new ProductCard($product))->render();
        }

        $html .= <<<EOF
                </ul>
            </div>
        </div>
        EOF;

        return $html;
    }
}
