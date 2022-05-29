<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;
    private CategoryService $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 10;

        if (request('page')) {
            $no = request('page') * $page - $page + 1;
        } else {
            $no = 1;
        }

        $products = $this->productService->getAll($page);

        return view('product.index', compact('products', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryService->getAll();

        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $product = $this->productService->create(new Product($request->all()));

        if ($product) {
            return redirect()->route('product.index')->with('success', 'Product created successfully');
        }

        return redirect()->route('product.index')->with('error', 'Product creation failed');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = $this->categoryService->getAll();

        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product = $this->productService->update($product->fill($request->all()));

        if ($product) {
            return redirect('/product/' . $product->id . '/edit')->with('success', 'Product updated successfully');
        }

        return redirect('/product/' . $product->id . '/edit')->with('error', 'Product update failed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $status = $this->productService->delete($product->id);
        if ($status) {
            //  redirect this page
            return redirect()->route('product.index')->with('success', 'Product deleted successfully');
        }

        return redirect()->route('product.index')->with('error', 'Product not found');
    }

    public function deleteMulti(Request $request)
    {
        $ids = $request->ids;
        $status = $this->productService->deleteMulti($ids);

        if ($status) {
            session()->flash('success', 'Products deleted successfully');
            return response()->json(['status' => true]);
        }

        session()->flash('error', 'Products not found');
        return response()->json(['status' => false]);
    }
}
