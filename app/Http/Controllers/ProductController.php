<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])
            ->latest()
            ->paginate(10);
        
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();
        
        // Get the last product code
        $lastProduct = Product::orderBy('code', 'desc')->first();
        $lastCode = $lastProduct ? (int)$lastProduct->code + 1 : 1;
        $nextCode = str_pad($lastCode, 4, '0', STR_PAD_LEFT);

        return view('products.create', compact('categories', 'brands', 'nextCode'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        
        // Generate unique product code
        $data['code'] = $this->generateProductCode();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'));
        }
        
        Product::create($data);
        
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();
        
        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::delete($product->image);
            }
            $data['image'] = $this->uploadImage($request->file('image'));
        }
        
        $product->update($data);
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete($product->image);
        }
        
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function generateProductCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Product::where('code', $code)->exists());
        
        return $code;
    }

    private function uploadImage($image)
    {
        return $image->store('products', 'public');
    }
}
