<?php

namespace App\Services;

use App\Models\Category;

interface CategoryService
{
    public function getAll();
    public function getById(int $id): Category;
    public function create(Category $category): Category;
    public function update(Category $category): Category;
    public function delete(int $id): bool;
    public function deleteMulti(array $ids): bool;
}
