<?php

namespace App\Services\Impl;

use App\Models\Category;
use App\Services\CategoryService;

class CategoryServiceImpl implements CategoryService
{
    public function getAll()
    {
        return Category::latest()->get();
    }

    public function getById(int $id): Category
    {
        if ($category = Category::find($id)) {
            return $category;
        }

        throw new \Exception('Category not found');
    }

    public function create(Category $category): Category
    {
        return Category::create($category->toArray());
    }

    public function update(Category $category): Category
    {
        $category->save();

        return $category;
    }

    public function delete(int $id): bool
    {
        if ($category = Category::find($id)) {
            $category->delete();

            return true;
        }

        return false;
    }

    public function deleteMulti(array $ids): bool
    {
        return Category::destroy($ids);
    }
}
