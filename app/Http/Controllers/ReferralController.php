<?php

namespace App\Http\Controllers;

use App\Models\ReferralTracking;
use App\Services\ReferralService;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    protected $referralService;
    
    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }
    
    /**
     * Process a referral link and redirect to the appropriate page.
     */
    public function processReferral($code)
    {
        $tracking = ReferralTracking::where('referral_code', $code)->first();
        
        if (!$tracking) {
            return redirect()->route('home')
                ->with('error', 'Invalid referral link.');
        }
        
        // Process the click
        $this->referralService->processReferralClick($code);
        
        // Redirect to the appropriate page based on item type
        if ($tracking->item_type === 'course') {
            $course = $tracking->course;
            
            if (!$course) {
                return redirect()->route('courses.index');
            }
            
            return redirect()->route('courses.show', $course->slug);
        } else {
            $product = $tracking->digitalProduct;
            
            if (!$product) {
                return redirect()->route('digital-products.index');
            }
            
            return redirect()->route('digital-products.show', $product->id);
        }
    }
}