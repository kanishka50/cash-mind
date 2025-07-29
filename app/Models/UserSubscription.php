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
        'stripe_subscription_id', // Can be removed later
        'starts_at',
        'ends_at',
        'is_active',
        'payment_status',
        'payment_method',
        'billing_cycle',
        'price',
        // New fields for manual payment
        'payment_receipt',
        'payment_receipt_uploaded_at',
        'payment_verified_by',
        'payment_verified_at',
        'admin_notes',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'payment_receipt_uploaded_at' => 'datetime',
        'payment_verified_at' => 'datetime',
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
     * Get the admin who verified the payment.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'payment_verified_by');
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

    /**
     * Check if subscription has payment receipt uploaded.
     */
    public function hasPaymentReceipt()
    {
        return !empty($this->payment_receipt);
    }

    /**
     * Check if subscription is awaiting payment verification.
     */
    public function isAwaitingVerification()
    {
        return $this->hasPaymentReceipt() && $this->payment_status === 'pending';
    }

    /**
     * Mark subscription as verified and activate it.
     */
    public function markAsVerified($adminId, $startsAt = null, $endsAt = null)
    {
        $startsAt = $startsAt ?? now();
        
        if (!$endsAt) {
            $endsAt = $this->billing_cycle === 'yearly' 
                ? $startsAt->copy()->addYear() 
                : $startsAt->copy()->addMonth();
        }
        
        $this->update([
            'payment_status' => 'completed',
            'payment_verified_by' => $adminId,
            'payment_verified_at' => now(),
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'is_active' => true,
        ]);
    }

    /**
     * Get the payment receipt URL.
     */
    public function getPaymentReceiptUrl()
    {
        if (!$this->payment_receipt) {
            return null;
        }
        
        return route('admin.subscriptions.receipt', $this);
    }

    /**
     * Scope a query to only include active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('ends_at', '>', now());
    }

    /**
     * Scope a query to only include subscriptions with pending receipts.
     */
    public function scopePendingReceipts($query)
    {
        return $query->whereNotNull('payment_receipt')
                    ->where('payment_status', 'pending');
    }

    /**
     * Get formatted price based on billing cycle.
     */
    public function getFormattedPrice()
    {
        $cycle = $this->billing_cycle === 'yearly' ? 'year' : 'month';
        return 'Rs. ' . number_format($this->price, 2) . ' / ' . $cycle;
    }

    /**
     * Get remaining days of subscription.
     */
    public function getRemainingDays()
    {
        if (!$this->ends_at) {
            return 0;
        }
        
        return max(0, now()->diffInDays($this->ends_at, false));
    }
}