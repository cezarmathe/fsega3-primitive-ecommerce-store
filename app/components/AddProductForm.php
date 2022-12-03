<?php

namespace ECommerce\App\Components;

class AddProductForm implements Component {
    public function render(): string {
        $html = <<<EOF
        <div class="add-product-form">
            <h2>Add Product</h2>
            <form action="/add-product.php" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group>
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image URL</label>
                    <input type="url" id="imageURL" name="imageURL" required>
                </div>
            </form>
        </div>
        EOF;

        return $html;
    }
}
