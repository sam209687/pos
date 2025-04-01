<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\BrandRequest;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')
            ->latest()
            ->paginate(10);
        
        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(BrandRequest $request)
    {
        Brand::create($request->validated());
        
        return redirect()->route('brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());
        
        return redirect()->route('brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->exists()) {
            return redirect()->route('brands.index')
                ->with('error', 'Cannot delete brand with associated products.');
        }
        
        $brand->delete();
        
        return redirect()->route('brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
