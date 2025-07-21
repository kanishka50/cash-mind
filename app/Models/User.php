<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Order;
use App\Models\ReferralTracking;
use App\Models\CommissionEarning;
use App\Models\PayoutRequest;


class User extends Authenticatable implements MustVerifyEmail
{
    // use HasApiTokens, HasFactory, Notifiable;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'google_id',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Get courses purchased by the user.
     */
   public function courses()
{
    return $this->belongsToMany(Course::class, 'user_courses')
        ->withPivot('purchased_at');
}

/**
 * Get the user's video progress.
 */
public function videoProgress()
{
    return $this->hasMany(VideoProgress::class);
}

    /**
     * Get user's active subscription if any.
     */
    // public function activeSubscription()
    // {
    //     return $this->hasOne(UserSubscription::class)
    //         ->where('is_active', true)
    //         ->whereNull('ends_at')
    //         ->orWhere('ends_at', '>', now())
    //         ->latest();
    // }

    /**
     * Get all user's subscriptions.
     */
    // public function subscriptions()
    // {
    //     return $this->hasMany(UserSubscription::class);
    // }

    /**
     * Get the user's wishlist items.
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function hasWishlisted(Course $course)
{
    // First, check if the wishlist relationship is already implemented
    if (method_exists($this, 'wishlist')) {
        return $this->wishlist()
            ->where('wishlist_type', 'course')
            ->where('item_id', $course->id)
            ->exists();
    }
    
    // If wishlist relationship isn't implemented yet, just return false
    return false;
}

    /**
     * Get the user's video progress.
     */
    // public function videoProgress()
    // {
    //     return $this->hasMany(VideoProgress::class);
    // }

    /**
     * Get the user's orders.
     */
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }


    /**
 * Get the subscriptions for the user.
 */
public function subscriptions()
{
    return $this->hasMany(UserSubscription::class);
}

/**
 * Get the active subscription for the user.
 */
public function activeSubscription()
{
    return $this->subscriptions()
        ->where('is_active', true)
        ->where(function($query) {
            $query->whereNull('ends_at')
                ->orWhere('ends_at', '>', now());
        })
        ->first();
}

/**
 * Check if the user has an active subscription.
 */
public function hasActiveSubscription()
{
    return $this->activeSubscription() !== null;
}

/**
 * Get the digital product keys purchased by the user.
 */
public function productKeys()
{
    return $this->hasMany(ProductKey::class, 'used_by');
}

/**
 * Check if the user has access to a course.
 */
public function hasAccessToCourse(Course $course)
{
    // Check if user has purchased the course individually
    if ($this->courses()->where('courses.id', $course->id)->exists()) {
        return true;
    }
    
    // Check if the course is included in user's active subscription
    $activeSubscription = $this->activeSubscription();
    if ($activeSubscription) {
        // Get the subscription plan
        $subscriptionPlan = $activeSubscription->subscriptionPlan;
        
        // Check if this course is included in the subscription plan
        if ($subscriptionPlan->courses()->where('courses.id', $course->id)->exists()) {
            return true;
        }
    }
    
    return false;
}

/**
 * Check if the user has access to a digital product.
 */
/**
 * Check if the user has access to a digital product.
 */
public function hasAccessToDigitalProduct(DigitalProduct $product)
{
    // Check if user has purchased the product individually
    if ($this->productKeys()->where('digital_product_id', $product->id)
        ->where('subscription_assigned', false)
        ->exists()) {
        return true;
    }
    
    // Check if the product is included in user's active subscription
    $activeSubscription = $this->activeSubscription();
    if ($activeSubscription) {
        // Get the subscription plan
        $subscriptionPlan = $activeSubscription->subscriptionPlan;
        
        // Check if this product is included in the subscription plan
        if ($subscriptionPlan->digitalProducts()->where('digital_products.id', $product->id)->exists()) {
            return true;
        }
    }
    
    return false;
}




/**
 * Get the orders for the user.
 */
public function orders()
{
    return $this->hasMany(Order::class);
}

/**
 * Check if user has an item in wishlist.
 */
public function hasInWishlist($itemId, $itemType)
{
    return $this->wishlist()
        ->where('item_id', $itemId)
        ->where('wishlist_type', $itemType)
        ->exists();
}





/**
 * Get the messages sent by the user.
 */
public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

/**
 * Get the messages received by the user.
 */
public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}

/**
 * Get the notifications for the user.
 */
public function notifications()
{
    return $this->hasMany(Notification::class);
}

/**
 * Get the number of unread messages for the user.
 */
public function unreadMessagesCount()
{
    return $this->receivedMessages()->where('is_read', false)->count();
}

/**
 * Get the number of unread notifications for the user.
 */
public function unreadNotificationsCount()
{
    return $this->notifications()->where('is_read', false)->count();
}

/**
 * Get user's courses.
 */
public function userCourses()
{
    return $this->hasMany(UserCourse::class);
}

/**
 * Get the user who referred this user.
 */
public function referrer()
{
    return $this->belongsTo(User::class, 'referred_by');
}

/**
 * Get the users referred by this user.
 */
public function referrals()
{
    return $this->hasMany(User::class, 'referred_by');
}

/**
 * Get the user's commission record.
 */
public function commission()
{
    return $this->hasOne(UserCommission::class);
}

/**
 * Get the user's referral tracking records.
 */
public function referralLinks()
{
    return $this->hasMany(ReferralTracking::class, 'referrer_id');
}

/**
 * Get the user's commission earnings.
 */
public function commissionEarnings()
{
    return $this->hasMany(CommissionEarning::class);
}

/**
 * Get the user's payout requests.
 */
public function payoutRequests()
{
    return $this->hasMany(PayoutRequest::class);
}

/**
 * Get the user's commission balance.
 */
public function getCommissionBalanceAttribute()
{
    $commission = $this->commission;
    return $commission ? $commission->balance : 0;
}

/**
 * Get the user's total earned commissions.
 */
public function getTotalEarnedCommissionsAttribute()
{
    $commission = $this->commission;
    return $commission ? $commission->total_earned : 0;
}

/**
 * Generate a unique referral code for a specific item.
 */
public function generateReferralCode($itemType, $itemId)
{
    // Check if a referral link already exists for this user and item
    $existingLink = $this->referralLinks()
        ->where('item_type', $itemType)
        ->where('item_id', $itemId)
        ->first();
    
    if ($existingLink) {
        return $existingLink->referral_code;
    }
    
    // Generate a new unique code
    $code = strtolower(substr(md5($this->id . $itemType . $itemId . time()), 0, 10));
    
    // Create a new tracking record
    ReferralTracking::create([
        'referrer_id' => $this->id,
        'referral_code' => $code,
        'item_type' => $itemType,
        'item_id' => $itemId,
        'clicks' => 0,
        'conversions' => 0
    ]);
    
    return $code;
}





}