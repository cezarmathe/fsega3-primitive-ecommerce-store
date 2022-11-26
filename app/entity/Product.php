<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class Product implements Entity {
    public int $id;

    public string $name;
    public float $price;
    public string $description;
    public string $imageURL;

    public static function fromArray(array $row, string $qualifier = ''): Product {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $product = new Product();

        $product->id = $row[$qualifier . 'id'];
        $product->name = $row[$qualifier . 'name'];
        $product->price = $row[$qualifier . 'price'];
        $product->description = $row[$qualifier . 'description'];
        $product->imageURL = $row[$qualifier . 'image_url'];

        return $product;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'image_url' => $this->imageURL,
        ];
    }
}
