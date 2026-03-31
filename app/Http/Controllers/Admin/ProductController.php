<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
    }

    public function index()
    {
        $this->authorizeAdmin();

        $products = Product::orderBy('category')->orderBy('name')->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorizeAdmin();

        Product::create($request->validated());

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $this->authorizeAdmin();

        return view('admin.products.edit', compact('product'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $this->authorizeAdmin();

        $product->update($request->validated());

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }
}
