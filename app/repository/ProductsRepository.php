<?php

namespace ECommerce\App\Repository;

use ECommerce\App\Entity\Product;

class ProductsRepository extends BaseRepository {
    // List returns all products in the catalog.
    public function list(): array {
        $result = $this->query('SELECT * FROM products');

        $products = [];

        while ($row = pg_fetch_assoc($result)) {
            $products[] = Product::fromArray($row);
        }

        return $products;
    }

    public function save(Product $product): Product {
        $columns = Product::columns();
        $q = <<<EOF
        insert into products (name, description, price)
        values ($1, $2, $3)
        returning {$columns}
        EOF;

        $result = $this->query($q, [
            $product->name,
            $product->description,
            $product->price,
        ]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Product not found.');
        }

        return Product::fromArray($row);
    }

    public function findByID($id): Product {
        $columns = implode(", ", Product::columns());
        $q = <<<EOF
        select {$columns}
        from products
        where id = $1
        EOF;
        $result = $this->query($q, [$id]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('Product not found.');
        }

        return Product::fromArray($row);
    }
}
