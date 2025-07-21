<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'valid_from',
        'valid_until',
        'max_uses',
        'times_used',
        'is_active',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the courses this coupon can be applied to.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'coupon_course');
    }

    /**
     * Get the digital products this coupon can be applied to.
     */
    public function digitalProducts()
    {
        return $this->belongsToMany(DigitalProduct::class, 'coupon_product');
    }

    /**
     * Get the orders that used this coupon.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if coupon is valid.
     */
    public function isValid()
    {
        // Check if coupon is active
        if (!$this->is_active) {
            return false;
        }

        // Check valid dates
        $now = Carbon::now();
        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }
        if ($this->valid_until && $now->gt($this->valid_until)) {
            return false;
        }

        // Check usage limit
        if ($this->max_uses && $this->times_used >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Get discount amount for a given total.
     */
    public function getDiscountAmount($total)
    {
        if ($this->type === 'percentage') {
            return ($this->value / 100) * $total;
        } else {
            return min($this->value, $total); // Fixed amount, but can't exceed total
        }
    }

    /**
     * Scope a query to only include active coupons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include valid coupons.
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('times_used < max_uses');
            });
    }
}