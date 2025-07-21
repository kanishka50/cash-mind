<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\DigitalProduct;
use App\Http\Requests\Admin\CouponRequest;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the coupons.
     */
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        $courses = Course::all();
        $digitalProducts = DigitalProduct::all();
        return view('admin.coupons.create', compact('courses', 'digitalProducts'));
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(CouponRequest $request)
    {
        $data = $request->validated();
        
        // Set is_active to false if not provided
        $data['is_active'] = $request->has('is_active');
        
        // Create coupon
        $coupon = Coupon::create($data);
        
        // Sync courses
        if ($request->has('course_ids')) {
            $coupon->courses()->sync($request->course_ids);
        }
        
        // Sync digital products
        if ($request->has('product_ids')) {
            $coupon->digitalProducts()->sync($request->product_ids);
        }
        
        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully!');
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit(Coupon $coupon)
    {
        $courses = Course::all();
        $digitalProducts = DigitalProduct::all();
        
        // Get current selections
        $selectedCourses = $coupon->courses()->pluck('courses.id')->toArray();
        $selectedProducts = $coupon->digitalProducts()->pluck('digital_products.id')->toArray();
        
        return view('admin.coupons.edit', compact(
            'coupon', 
            'courses', 
            'digitalProducts', 
            'selectedCourses', 
            'selectedProducts'
        ));
    }

    /**
     * Update the specified coupon in storage.
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $data = $request->validated();
        
        // Set is_active to false if not provided
        $data['is_active'] = $request->has('is_active');
        
        // Update coupon
        $coupon->update($data);
        
        // Sync courses
        if ($request->has('course_ids')) {
            $coupon->courses()->sync($request->course_ids);
        } else {
            $coupon->courses()->detach();
        }
        
        // Sync digital products
        if ($request->has('product_ids')) {
            $coupon->digitalProducts()->sync($request->product_ids);
        } else {
            $coupon->digitalProducts()->detach();
        }
        
        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully!');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->courses()->detach();
        $coupon->digitalProducts()->detach();
        $coupon->delete();
        
        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully!');
    }
}