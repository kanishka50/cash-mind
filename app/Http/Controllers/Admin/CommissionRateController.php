<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionRate;
use App\Models\Course;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;

class CommissionRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('\App\Http\Middleware\AdminMiddleware');
    }
    
    /**
     * Display a listing of the commission rates.
     */
    public function index()
    {
        // Get course commission rates
        $courseRates = CommissionRate::where('item_type', 'course')
            ->with('course')
            ->get();
            
        // Get digital product commission rates
        $productRates = CommissionRate::where('item_type', 'digital_product')
            ->with('digitalProduct')
            ->get();
            
        // Get courses without commission rates
        $coursesWithoutRates = Course::whereDoesntHave('commissionRate')->get();
        
        // Get digital products without commission rates
        $productsWithoutRates = DigitalProduct::whereDoesntHave('commissionRate')->get();
        
        return view('admin.commission-rates.index', compact(
            'courseRates', 
            'productRates',
            'coursesWithoutRates',
            'productsWithoutRates'
        ));
    }
    
    /**
     * Show the form for creating a new commission rate.
     */
    public function create()
    {
        // Get courses without commission rates
        $courses = Course::whereDoesntHave('commissionRate')->get();
        
        // Get digital products without commission rates
        $products = DigitalProduct::whereDoesntHave('commissionRate')->get();
        
        return view('admin.commission-rates.create', compact('courses', 'products'));
    }
    
    /**
     * Store a newly created commission rate in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:course,digital_product',
            'item_id' => 'required|integer',
            'rate' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ]);
        
        // Check if a commission rate already exists for this item
        $existingRate = CommissionRate::where('item_type', $request->item_type)
            ->where('item_id', $request->item_id)
            ->first();
            
        if ($existingRate) {
            return redirect()->back()
                ->with('error', 'A commission rate already exists for this item.');
        }
        
        // Create the commission rate
        CommissionRate::create([
            'item_type' => $request->item_type,
            'item_id' => $request->item_id,
            'rate' => $request->rate,
            'is_active' => $request->has('is_active')
        ]);
        
        return redirect()->route('admin.commission-rates.index')
            ->with('success', 'Commission rate created successfully.');
    }
    
    /**
     * Show the form for editing the specified commission rate.
     */
    public function edit(CommissionRate $commissionRate)
    {
        // Get the item name
        $itemName = '';
        
        if ($commissionRate->item_type === 'course') {
            $course = Course::find($commissionRate->item_id);
            $itemName = $course ? $course->title : 'Unknown Course';
        } else {
            $product = DigitalProduct::find($commissionRate->item_id);
            $itemName = $product ? $product->name : 'Unknown Product';
        }
        
        return view('admin.commission-rates.edit', compact('commissionRate', 'itemName'));
    }
    
    /**
     * Update the specified commission rate in storage.
     */
    public function update(Request $request, CommissionRate $commissionRate)
    {
        $request->validate([
            'rate' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ]);
        
        // Update the commission rate
        $commissionRate->update([
            'rate' => $request->rate,
            'is_active' => $request->has('is_active')
        ]);
        
        return redirect()->route('admin.commission-rates.index')
            ->with('success', 'Commission rate updated successfully.');
    }
    
    /**
     * Remove the specified commission rate from storage.
     */
    public function destroy(CommissionRate $commissionRate)
    {
        $commissionRate->delete();
        
        return redirect()->route('admin.commission-rates.index')
            ->with('success', 'Commission rate deleted successfully.');
    }
    
    /**
     * Toggle the active status of the specified commission rate.
     */
    public function toggleActive(CommissionRate $commissionRate)
    {
        $commissionRate->is_active = !$commissionRate->is_active;
        $commissionRate->save();
        
        $status = $commissionRate->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.commission-rates.index')
            ->with('success', "Commission rate {$status} successfully.");
    }
}