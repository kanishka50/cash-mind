<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use App\Models\DigitalProduct;
use App\Models\ReferralTracking;
use App\Models\CommissionRate;
use App\Models\CommissionEarning;
use App\Models\UserCommission;
use App\Models\Order;
use Illuminate\Support\Facades\Cookie;

class ReferralService
{
    /**
     * The cookie name for storing referral code.
     */
    protected $cookieName = 'cash_mind_ref';
    
    /**
     * The cookie expiration time in minutes (30 days).
     */
    protected $cookieExpiration = 43200;

    /**
     * Process a referral link click.
     */
    public function processReferralClick($referralCode)
    {
        // Find the referral tracking record
        $tracking = ReferralTracking::where('referral_code', $referralCode)->first();
        
        if (!$tracking) {
            return false;
        }
        
        // Increment the click counter
        $tracking->incrementClicks();
        
        // Set the referral cookie
        $this->setReferralCookie($referralCode);
        
        return $tracking;
    }

    /**
     * Set the referral cookie.
     */
    public function setReferralCookie($referralCode)
    {
        Cookie::queue(
            $this->cookieName,
            $referralCode,
            $this->cookieExpiration
        );
    }

    /**
     * Get the referral code from cookie.
     */
    public function getReferralCodeFromCookie()
    {
        return Cookie::get($this->cookieName);
    }

    /**
     * Clear the referral cookie.
     */
    public function clearReferralCookie()
    {
        Cookie::queue(Cookie::forget($this->cookieName));
    }

    /**
     * Associate a new user with a referrer based on cookie.
     */
    public function associateUserWithReferrer(User $user)
    {
        $referralCode = $this->getReferralCodeFromCookie();
        
        if (!$referralCode) {
            return false;
        }
        
        $tracking = ReferralTracking::where('referral_code', $referralCode)->first();
        
        if (!$tracking || $tracking->referrer_id === $user->id) {
            return false;
        }
        
        // Associate the user with the referrer
        $user->referred_by = $tracking->referrer_id;
        $user->referral_code = $referralCode;
        $user->referral_registered_at = now();
        $user->save();
        
        return true;
    }

    /**
     * Process commission for an order if eligible.
     * Fixed to prevent duplicate commission entries.
     */
    public function processCommissionForOrder(Order $order)
    {
        // Check if commissions have already been processed for this order
        if (CommissionEarning::where('order_id', $order->id)->exists()) {
            return false; // Commissions already processed for this order
        }
        
        $user = $order->user;
        
        // Check if the user was referred
        if (!$user->referred_by || !$user->referral_code) {
            return false;
        }
        
        // Find the referrer
        $referrer = User::find($user->referred_by);
        
        if (!$referrer) {
            return false;
        }
        
        // Find the tracking record
        $tracking = ReferralTracking::where('referral_code', $user->referral_code)->first();
        
        if (!$tracking) {
            return false;
        }
        
        // Process each order item
        $commissionProcessed = false;
        
        foreach ($order->orderItems as $item) {
            // Check if the order item matches the referred item
            if ($item->item_type === $tracking->item_type && $item->item_id === $tracking->item_id) {
                // Check if there's an active commission rate for this item
                $commissionRate = CommissionRate::where('item_type', $item->item_type)
                    ->where('item_id', $item->item_id)
                    ->where('is_active', true)
                    ->first();
                
                if (!$commissionRate) {
                    continue;
                }
                
                // Calculate commission amount
                $commissionAmount = ($item->price * $commissionRate->rate) / 100;
                
                // Create commission earning record
                $earning = CommissionEarning::create([
                    'user_id' => $referrer->id,
                    'referred_user_id' => $user->id,
                    'referral_code' => $user->referral_code,
                    'order_id' => $order->id,
                    'item_type' => $item->item_type,
                    'item_id' => $item->item_id,
                    'amount' => $commissionAmount,
                    'rate_used' => $commissionRate->rate,
                    'status' => 'pending'
                ]);
                
                // Update user commission balance
                $userCommission = UserCommission::firstOrCreate(
                    ['user_id' => $referrer->id],
                    ['balance' => 0, 'total_earned' => 0]
                );
                
                $userCommission->addCommission($commissionAmount);
                
                // Increment the conversions counter - but only once per referral code and item
                $tracking->incrementConversions();
                
                $commissionProcessed = true;
                
                // Only process one commission per item type/id - prevents duplicates
                break;
            }
        }
        
        return $commissionProcessed;
    }

    /**
     * Generate a referral URL for a specific item.
     */
    public function generateReferralUrl(User $user, $itemType, $itemId)
    {
        $code = $user->generateReferralCode($itemType, $itemId);
        return url("/ref/{$code}");
    }
}