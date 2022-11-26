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
}
