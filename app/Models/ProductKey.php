<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'digital_product_id',
        'key_value',
        'is_used',
        'used_by',
        'used_at',
        'subscription_assigned',
        'expires_at',           // NEW
        'subscription_id', 
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'subscription_assigned' => 'boolean',
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the digital product that owns the key.
     */
    public function digitalProduct()
    {
        return $this->belongsTo(DigitalProduct::class);
    }

    /**
     * Get the user that used this key.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }
     /**
     * NEW: Relationship to subscription
     */
    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class);
    }

    /**
     * Mark the key as used by a specific user.
     * This method is called when an order is completed.
     * 
     * @param int $userId
     * @param bool $isSubscriptionAssigned Default false for regular purchases
     * @return bool
     */
     public function markAsUsed($userId, $isSubscriptionAssigned = false, $subscriptionId = null, $expiresAt = null)
    {
        // Only mark as used if not already used
        if ($this->is_used) {
            return false;
        }

        $this->update([
            'is_used' => true,
            'used_by' => $userId,
            'used_at' => now(),
            'subscription_assigned' => $isSubscriptionAssigned,
            'subscription_id' => $subscriptionId,      // NEW
            'expires_at' => $expiresAt,               // NEW
        ]);

        // Update the digital product's inventory count
        if ($this->digitalProduct) {
            $this->digitalProduct->update([
                'inventory_count' => $this->digitalProduct->availableKeys()->count()
            ]);
        }

        return true;
    }


     /**
     * NEW: Reset key (for subscription changes)
     */
    public function resetKey()
    {
        $this->update([
            'is_used' => false,
            'used_by' => null,
            'used_at' => null,
            'subscription_assigned' => false,
            'subscription_id' => null,
            'expires_at' => null,
        ]);

        // Update the digital product's inventory count
        if ($this->digitalProduct) {
            $this->digitalProduct->update([
                'inventory_count' => $this->digitalProduct->availableKeys()->count()
            ]);
        }

        return true;
    }

    /**
     * NEW: Check if key is valid
     */
    public function isValid()
    {
        // Non-subscription keys are always valid
        if (!$this->subscription_assigned) {
            return true;
        }
        
        // Subscription keys check expiry
        return $this->expires_at === null || $this->expires_at->isFuture();
    }

    /**
     * NEW: Scope for valid keys
     */
    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->where('subscription_assigned', false)
              ->orWhere(function ($sub) {
                  $sub->where('subscription_assigned', true)
                      ->where(function ($exp) {
                          $exp->whereNull('expires_at')
                              ->orWhere('expires_at', '>', now());
                      });
              });
        });
    }

    /**
     * Release the key (mark as unused).
     * This can be used when refunding or canceling an order.
     * 
     * @return bool
     */
    public function release()
    {
        if (!$this->is_used) {
            return false;
        }

        $this->update([
            'is_used' => false,
            'used_by' => null,
            'used_at' => null,
            'subscription_assigned' => false
        ]);

        // Update the digital product's inventory count
        if ($this->digitalProduct) {
            $this->digitalProduct->update([
                'inventory_count' => $this->digitalProduct->availableKeys()->count()
            ]);
        }

        return true;
    }

    /**
     * Check if the key is available (not used).
     * 
     * @return bool
     */
    public function isAvailable()
    {
        return !$this->is_used;
    }

    /**
     * Check if the key was assigned through a subscription.
     * 
     * @return bool
     */
    public function isSubscriptionAssigned()
    {
        return $this->subscription_assigned;
    }

    /**
     * Scope a query to only include available keys.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_used', false);
    }

    /**
     * Scope a query to only include used keys.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsed($query)
    {
        return $query->where('is_used', true);
    }

    /**
     * Scope a query to only include subscription-assigned keys.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubscriptionAssigned($query)
    {
        return $query->where('subscription_assigned', true);
    }

    /**
     * Scope a query to only include individually purchased keys.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePurchased($query)
    {
        return $query->where('is_used', true)
                    ->where('subscription_assigned', false);
    }
}