<?php

namespace App\Services;

use App\Models\Product;

interface ProductService
{
    public function getAll(int $page);
    public function getById(int $id): Product;
    public function create(Product $product): Product;
    public function update(Product $product): Product;
    public function delete(int $id): bool;
    public function deleteMulti(array $ids): bool;
}
