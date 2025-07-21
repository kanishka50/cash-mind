<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\DigitalProduct;
use App\Models\SubscriptionPlan;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get featured courses (already implemented)
        $featuredCourses = Course::where('is_featured', true)
            ->with('category')
            ->limit(3)
            ->get();
            
        // Get featured digital products
        $featuredProducts = DigitalProduct::where('is_featured', true)
            ->limit(3)
            ->get();
            
        // Get all subscription plans
        $subscriptionPlans = SubscriptionPlan::orderBy('price_monthly', 'asc')
            ->get();
            
        return view('home', compact('featuredCourses', 'featuredProducts', 'subscriptionPlans'));
    }
}