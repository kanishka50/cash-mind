<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\DigitalProduct;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
{
    if (!$request->user()) {
        return redirect()->route('login');
    }

    $user = $request->user();
    
    // Check if user has an active subscription
    $activeSubscription = $user->activeSubscription();
    
    if (!$activeSubscription) {
        return redirect()->route('subscription-plans.index')
            ->with('error', 'You need an active subscription to access this content.');
    }
    
    // Get the subscription plan
    $subscriptionPlan = $activeSubscription->subscriptionPlan;
    
    // If we're accessing a course, check if it's in the plan
    if ($request->route('course')) {
        $course = $request->route('course');
        
        // If this course is not in user's subscription plan, check if user purchased it individually
        if (!$subscriptionPlan->courses()->where('courses.id', $course->id)->exists()) {
            // Check if user purchased the course individually
            if (!$user->courses()->where('courses.id', $course->id)->exists()) {
                return redirect()->route('courses.show', $course)
                    ->with('error', 'This course is not included in your subscription plan or purchases.');
            }
        }
    }
    
    // If we're accessing a digital product, check if it's in the plan
    if ($request->route('digitalProduct')) {
        $product = $request->route('digitalProduct');
        
        // If this product is not in user's subscription plan, check if user purchased it individually
        if (!$subscriptionPlan->digitalProducts()->where('digital_products.id', $product->id)->exists()) {
            // Check if user purchased the product individually (via product keys)
            if (!$user->productKeys()->whereHas('digitalProduct', function($query) use ($product) {
                $query->where('id', $product->id);
            })->exists()) {
                return redirect()->route('digital-products.show', $product)
                    ->with('error', 'This digital product is not included in your subscription plan or purchases.');
            }
        }
    }

    return $next($request);
}
}