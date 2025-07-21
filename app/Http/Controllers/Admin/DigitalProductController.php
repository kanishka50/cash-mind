<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalProduct;
use App\Http\Requests\Admin\DigitalProductRequest;
use Illuminate\Http\Request;

class DigitalProductController extends Controller
{
    /**
     * Display a listing of the digital products.
     */
    public function index()
    {
        $digitalProducts = DigitalProduct::all();
        return view('admin.digital-products.index', compact('digitalProducts'));
    }

    /**
     * Show the form for creating a new digital product.
     */
    public function create()
    {
        return view('admin.digital-products.create');
    }

    /**
     * Store a newly created digital product in storage.
     */
    public function store(DigitalProductRequest $request)
    {
        $digitalProduct = DigitalProduct::create($request->validated());
        
        return redirect()->route('admin.digital-products.index')
            ->with('success', 'Digital product created successfully!');
    }

    /**
     * Show the form for editing the specified digital product.
     */
    public function edit(DigitalProduct $digitalProduct)
    {
        return view('admin.digital-products.edit', compact('digitalProduct'));
    }

    /**
     * Update the specified digital product in storage.
     */
    public function update(DigitalProductRequest $request, DigitalProduct $digitalProduct)
    {
        $digitalProduct->update($request->validated());
        
        return redirect()->route('admin.digital-products.index')
            ->with('success', 'Digital product updated successfully!');
    }

    /**
     * Remove the specified digital product from storage.
     */
    public function destroy(DigitalProduct $digitalProduct)
    {
        // Check if product has been purchased
        $hasPurchases = $digitalProduct->productKeys()->where('is_used', true)->exists();
        if ($hasPurchases) {
            return redirect()->route('admin.digital-products.index')
                ->with('error', 'Cannot delete digital product with active purchases!');
        }
        
        $digitalProduct->delete();
        return redirect()->route('admin.digital-products.index')
            ->with('success', 'Digital product deleted successfully!');
    }
}