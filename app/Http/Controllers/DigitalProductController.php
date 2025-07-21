<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use Illuminate\Http\Request;

class DigitalProductController extends Controller
{
    /**
     * Display a listing of the digital products.
     */
    public function index()
    {
        $digitalProducts = DigitalProduct::where('inventory_count', '>', 0)->get();
        return view('digital-products', compact('digitalProducts'));
    }
    
    /**
     * Display the specified digital product.
     */
    public function show(DigitalProduct $digitalProduct)
    {
        return view('digital-product-detail', compact('digitalProduct'));
    }
}