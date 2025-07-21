<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'stripe_subscription_id',
        'starts_at',
        'ends_at',
        'is_active',
        'payment_status',
        'payment_method',
        'billing_cycle',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan.
     */
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Check if subscription is expired.
     */
    public function isExpired()
    {
        return $this->ends_at && $this->ends_at->isPast();
    }

    /**
     * Check if subscription will expire soon (7 days).
     */
    public function isExpiringSoon()
    {
        return $this->ends_at && $this->ends_at->diffInDays(now()) <= 7;
    }
}