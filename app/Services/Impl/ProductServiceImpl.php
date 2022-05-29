<?php

namespace App\Services\Impl;

use App\Models\Product;
use App\Services\ProductService;

class ProductServiceImpl implements ProductService
{
    public function getAll($page)
    {
        return Product::with('category')->latest()->paginate($page);
    }

    public function getById(int $id): Product
    {
        if ($product = Product::find($id)) {
            return $product;
        }

        throw new \Exception('Product not found');
    }

    public function create(Product $product): Product
    {
        return Product::create($product->toArray());
    }

    public function update(Product $product): Product
    {
        $product->save();

        return $product;
    }

    public function delete(int $id): bool
    {
        if ($product = Product::find($id)) {
            $product->delete();

            return true;
        }

        return false;
    }

    public function deleteMulti(array $ids): bool
    {
        return Product::destroy($ids);
    }
}
