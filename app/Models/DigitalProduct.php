<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'inventory_count',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the product keys for the digital product.
     */
    public function productKeys()
    {
        return $this->hasMany(ProductKey::class);
    }

    /**
     * Get the available (unused) product keys.
     */
    public function availableKeys()
    {
        return $this->productKeys()->where('is_used', false);
    }

    /**
     * Get the available keys count.
     */
    public function getAvailableKeysCountAttribute()
    {
        return $this->availableKeys()->count();
    }

    /**
     * Check if the product is in stock.
     */
    public function isInStock()
    {
        return $this->availableKeys()->count() > 0;
    }

    /**
     * Get the coupons for this product.
     */
    // public function coupons()
    // {
    //     return $this->belongsToMany(Coupon::class, 'coupon_product');
    // }

    public function subscriptionPlans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'subscription_plan_digital_product')
            ->withTimestamps();
    }

    /**
 * Get the commission rate for this product.
 */
public function commissionRate()
{
    return $this->hasOne(CommissionRate::class, 'item_id')
        ->where('item_type', 'digital_product');
}

/**
 * Get the current active commission rate percentage.
 */
public function getActiveCommissionRateAttribute()
{
    $rate = $this->commissionRate()->where('is_active', true)->first();
    return $rate ? $rate->rate : null;
}

/**
 * Check if this product has an active commission rate.
 */
public function hasActiveCommissionRate()
{
    return $this->commissionRate()->where('is_active', true)->exists();
}

/**
 * Get the referral links for this product.
 */
public function referralLinks()
{
    return $this->hasMany(ReferralTracking::class, 'item_id')
        ->where('item_type', 'digital_product');
}
}