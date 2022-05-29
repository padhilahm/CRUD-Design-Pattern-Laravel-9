<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;

        $categories = $this->categoryService->getAll();

        return view('category.index', compact('categories', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = $this->categoryService->create(new Category($request->all()));

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Category has been created');
        }

        return redirect()->route('category.index')->with('error', 'Category has not been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category = $this->categoryService->update($category->fill($request->all()));

        if ($category) {
            return redirect('/category/' . $category->id . '/edit')->with('success', 'Category has been updated');
        }

        return redirect('/category/' . $category->id . '/edit')->with('error', 'Category has not been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category = $this->categoryService->delete($category->id);

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Category has been deleted');
        }

        return redirect()->route('category.index')->with('error', 'Category has not been deleted');
    }

    public function deleteMulti(Request $request)
    {
        $ids = $request->ids;

        $status = $this->categoryService->deleteMulti($ids);

        if ($status) {
            session()->flash('success', 'Categories has been deleted');
            return redirect()->route('category.index')->with('success', 'Category has been deleted');
        }

        session()->flash('error', 'Categories has not been deleted');
        return redirect()->route('category.index')->with('error', 'Category has not been deleted');
    }
}
