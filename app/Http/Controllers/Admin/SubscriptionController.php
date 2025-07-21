<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Http\Requests\Admin\SubscriptionPlanRequest;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\DigitalProduct;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the subscription plans.
     */
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::all();
        return view('admin.subscriptions.index', compact('subscriptionPlans'));
    }

    /**
     * Show the form for creating a new subscription plan.
     */
    public function create()
    {
        return view('admin.subscriptions.create');
    }

    /**
     * Store a newly created subscription plan in storage.
     */
    public function store(SubscriptionPlanRequest $request)
    {
        SubscriptionPlan::create($request->validated());
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription plan created successfully!');
    }

    /**
     * Show the form for editing the specified subscription plan.
     */
    public function edit(SubscriptionPlan $subscription)
    {
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified subscription plan in storage.
     */
    public function update(SubscriptionPlanRequest $request, SubscriptionPlan $subscription)
    {
        $subscription->update($request->validated());
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription plan updated successfully!');
    }

    /**
     * Remove the specified subscription plan from storage.
     */
    public function destroy(SubscriptionPlan $subscription)
    {
        // Check if there are active subscriptions using this plan
        if ($subscription->userSubscriptions()->where('is_active', true)->exists()) {
            return redirect()->route('admin.subscriptions.index')
                ->with('error', 'Cannot delete subscription plan with active subscribers!');
        }
        
        $subscription->delete();
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription plan deleted successfully!');
    }

    public function manageContent(SubscriptionPlan $subscription)
    {
        // Get all courses
        $courses = Course::all();
        
        // Get all digital products
        $digitalProducts = DigitalProduct::all();
        
        // Get the IDs of courses already in the plan
        $planCourseIds = $subscription->courses()->pluck('courses.id')->toArray();
        
        // Get the IDs of digital products already in the plan
        $planProductIds = $subscription->digitalProducts()->pluck('digital_products.id')->toArray();
        
        return view('admin.subscriptions.manage-content', compact(
            'subscription', 
            'courses', 
            'digitalProducts', 
            'planCourseIds', 
            'planProductIds'
        ));
    }

    public function updateContent(Request $request, SubscriptionPlan $subscription)
    {
        // Validate the request
        $validated = $request->validate([
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:digital_products,id',
        ]);
        
        // Update courses in the subscription plan
        $courseIds = $request->input('course_ids', []);
        $subscription->courses()->sync($courseIds);
        
        // Update digital products in the subscription plan
        $productIds = $request->input('product_ids', []);
        $subscription->digitalProducts()->sync($productIds);
        
        return redirect()->route('admin.subscriptions.manage-content', $subscription)
            ->with('success', 'Subscription plan content updated successfully!');
    }
}