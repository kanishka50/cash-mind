<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalProduct;
use App\Models\ProductKey;
use App\Http\Requests\Admin\ProductKeyRequest;
use Illuminate\Http\Request;

class ProductKeyController extends Controller
{
    /**
     * Display a listing of keys for a digital product.
     */
    public function index(DigitalProduct $digitalProduct)
    {
        $productKeys = $digitalProduct->productKeys()->paginate(15);
        return view('admin.digital-products.keys', compact('digitalProduct', 'productKeys'));
    }

    /**
     * Store a newly created product key in storage.
     */
    public function store(ProductKeyRequest $request, DigitalProduct $digitalProduct)
    {
        $data = $request->validated();
        $keyCount = $data['key_count'] ?? 1;
        
        if ($request->has('bulk_keys')) {
            $keys = explode("\n", $request->bulk_keys);
            foreach ($keys as $key) {
                $key = trim($key);
                if (!empty($key)) {
                    $digitalProduct->productKeys()->create([
                        'key_value' => $key,
                        'is_used' => false,
                    ]);
                }
            }
        } else {
            // Generate individual keys
            for ($i = 0; $i < $keyCount; $i++) {
                $digitalProduct->productKeys()->create([
                    'key_value' => $data['key_value'],
                    'is_used' => false,
                ]);
            }
        }
        
        // Update inventory count
        $digitalProduct->update([
            'inventory_count' => $digitalProduct->availableKeys()->count()
        ]);
        
        return redirect()->route('admin.digital-products.keys', $digitalProduct)
            ->with('success', 'Product keys added successfully!');
    }

    /**
     * Remove the specified product key from storage.
     */
    public function destroy(DigitalProduct $digitalProduct, ProductKey $key)
    {
        if ($key->is_used) {
            return redirect()->route('admin.digital-products.keys', $digitalProduct)
                ->with('error', 'Cannot delete a used product key!');
        }
        
        $key->delete();
        
        // Update inventory count
        $digitalProduct->update([
            'inventory_count' => $digitalProduct->availableKeys()->count()
        ]);
        
        return redirect()->route('admin.digital-products.keys', $digitalProduct)
            ->with('success', 'Product key deleted successfully!');
    }
}