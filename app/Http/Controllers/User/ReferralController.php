<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DigitalProduct;
use App\Models\ReferralTracking;
use App\Models\CommissionEarning;
use App\Models\UserCommission;
use App\Models\PayoutRequest;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ReferralController extends Controller
{
    protected $referralService;
    
    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = Auth::user();
        
        // Get commission statistics
        $commission = $user->commission ?? UserCommission::create([
            'user_id' => $user->id,
            'balance' => 0,
            'total_earned' => 0
        ]);
        
        // Get all active courses with commission rates
        $courses = Course::whereHas('commissionRate', function ($query) {
            $query->where('is_active', true);
        })->get();
        
        // Get all active digital products with commission rates
        $digitalProducts = DigitalProduct::whereHas('commissionRate', function ($query) {
            $query->where('is_active', true);
        })->get();
        
        // Get user's referral links
        $referralLinks = ReferralTracking::where('referrer_id', Auth::id())->get();
        
        // Get course and product IDs from referral links
        $courseIds = $referralLinks->where('item_type', 'course')->pluck('item_id')->toArray();
        $productIds = $referralLinks->where('item_type', 'digital_product')->pluck('item_id')->toArray();
        
        // Fetch courses and products in bulk
        $coursesMap = [];
        $productsMap = [];
        
        if (!empty($courseIds)) {
            $coursesMap = Course::whereIn('id', $courseIds)->get()->keyBy('id');
        }
        
        if (!empty($productIds)) {
            $productsMap = DigitalProduct::whereIn('id', $productIds)->get()->keyBy('id');
        }
        
        // Attach the course or product to each referral link
        foreach ($referralLinks as $link) {
            if ($link->item_type === 'course' && isset($coursesMap[$link->item_id])) {
                $link->setRelation('course', $coursesMap[$link->item_id]);
            } else if ($link->item_type === 'digital_product' && isset($productsMap[$link->item_id])) {
                $link->setRelation('digitalProduct', $productsMap[$link->item_id]);
            }
        }
        
        // Get recent earnings - empty array if none exist
        $recentEarnings = collect([]);
        
        try {
            if (CommissionEarning::where('user_id', Auth::id())->exists()) {
                $recentEarnings = CommissionEarning::where('user_id', Auth::id())
                    ->with('referredUser')
                    ->latest()
                    ->take(5)
                    ->get();
                
                // Manually load course or product based on item_type
                foreach ($recentEarnings as $earning) {
                    if ($earning->item_type === 'course') {
                        $earning->course = Course::find($earning->item_id);
                    } else if ($earning->item_type === 'digital_product') {
                        $earning->digitalProduct = DigitalProduct::find($earning->item_id);
                    }
                }
            }
        } catch (\Exception $e) {
            // Already have empty collection
        }
        
        return view('user.referrals.index', compact(
            'commission',
            'courses',
            'digitalProducts',
            'referralLinks',
            'recentEarnings'
        ));
    }
    
    /**
     * Generate a referral link for a specific item.
     */
    public function generateLink(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:course,digital_product',
            'item_id' => 'required|integer'
        ]);
        
        $user = Auth::user();
        $itemType = $request->item_type;
        $itemId = $request->item_id;
        
        // Check if the item exists and has an active commission rate
        if ($itemType === 'course') {
            $item = Course::find($itemId);
            
            if (!$item) {
                return redirect()->back()
                    ->with('error', 'Course not found.');
            }
            
            if (!$item->hasActiveCommissionRate()) {
                return redirect()->back()
                    ->with('error', 'This course does not have an active commission rate.');
            }
        } else {
            $item = DigitalProduct::find($itemId);
            
            if (!$item) {
                return redirect()->back()
                    ->with('error', 'Digital product not found.');
            }
            
            if (!$item->hasActiveCommissionRate()) {
                return redirect()->back()
                    ->with('error', 'This product does not have an active commission rate.');
            }
        }
        
        // Generate the referral URL
        $referralUrl = $this->referralService->generateReferralUrl($user, $itemType, $itemId);
        
        // Redirect back with the URL
        return redirect()->back()
            ->with('referral_url', $referralUrl)
            ->with('success', 'Referral link generated successfully.');
    }
    
    public function commissions()
    {
        $user = Auth::user();
        
        // Get commission statistics
        $commission = $user->commission ?? UserCommission::create([
            'user_id' => $user->id,
            'balance' => 0,
            'total_earned' => 0
        ]);
        
        // Get all earnings with pagination
        $earnings = CommissionEarning::where('user_id', Auth::id())
            ->with('referredUser')
            ->latest()
            ->paginate(10);
        
        // Manually load courses and digital products for each earning
        // This avoids the problematic eager loading for polymorphic relationships
        foreach ($earnings as $earning) {
            if ($earning->item_type === 'course') {
                $earning->course = Course::find($earning->item_id);
            } else if ($earning->item_type === 'digital_product') {
                $earning->digitalProduct = DigitalProduct::find($earning->item_id);
            }
        }
        
        return view('user.referrals.commissions', compact('commission', 'earnings'));
    }
    
    public function payouts()
    {
        $user = Auth::user();
        
        // Get commission statistics
        $commission = $user->commission ?? UserCommission::create([
            'user_id' => $user->id,
            'balance' => 0,
            'total_earned' => 0
        ]);
        
        // Get all payout requests with pagination
        $payouts = PayoutRequest::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('user.referrals.payouts', compact('commission', 'payouts'));
    }
    
    /**
     * Show the form for requesting a payout.
     */
    public function showPayoutForm()
    {
        $user = Auth::user();
        $commission = $user->commission;
        
        if (!$commission || $commission->balance <= 0) {
            return redirect()->route('user.referrals.payouts')
                ->with('error', 'You do not have any commission balance to request a payout.');
        }
        
        return view('user.referrals.payout-request', compact('commission'));
    }
    
    /**
     * Process a payout request.
     */
    public function requestPayout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'payment_details' => 'required|string'
        ]);
        
        $user = Auth::user();
        $commission = $user->commission;
        
        if (!$commission || $commission->balance < $request->amount) {
            return redirect()->back()
                ->with('error', 'Insufficient commission balance for this payout request.');
        }
        
        // Create the payout request
        PayoutRequest::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_details' => json_encode(['details' => $request->payment_details]),
            'status' => 'pending'
        ]);
        
        return redirect()->route('user.referrals.payouts')
            ->with('success', 'Payout request submitted successfully. It will be processed by an administrator.');
    }
}