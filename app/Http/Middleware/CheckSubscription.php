<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        
        // Check course access
        if ($request->route('course')) {
            $course = $request->route('course');
            
            if (!$user->hasAccessToCourse($course)) {
                return redirect()->route('courses.show', $course)
                    ->with('error', 'You need to purchase this course or have an active subscription.');
            }
        }
        
        // Check digital product access
        if ($request->route('digitalProduct')) {
            $product = $request->route('digitalProduct');
            
            if (!$user->hasAccessToDigitalProduct($product)) {
                return redirect()->route('digital-products.show', $product)
                    ->with('error', 'You need to purchase this product or have an active subscription.');
            }
        }

        return $next($request);
    }
}