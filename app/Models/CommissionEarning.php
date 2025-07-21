<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referred_user_id',
        'referral_code',
        'order_id',
        'item_type',
        'item_id',
        'amount',
        'rate_used',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'rate_used' => 'decimal:2'
    ];

    /**
     * Get the user (referrer) that earned the commission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the referred user who made the purchase.
     */
    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

    /**
     * Get the order that generated this commission.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the related course if item_type is 'course'.
     * We need to manually define this relationship without using polymorphic
     * relations to avoid the "Call to a member function addEagerConstraints() on null" error.
     */
    public function course()
    {
        if ($this->item_type === 'course') {
            return $this->belongsTo(Course::class, 'item_id');
        }
        return null;
    }

    /**
     * Get the related digital product if item_type is 'digital_product'.
     * We need to manually define this relationship without using polymorphic
     * relations to avoid the "Call to a member function addEagerConstraints() on null" error.
     */
    public function digitalProduct()
    {
        if ($this->item_type === 'digital_product') {
            return $this->belongsTo(DigitalProduct::class, 'item_id');
        }
        return null;
    }

    /**
     * Mark this commission as paid.
     */
    public function markAsPaid()
    {
        $this->status = 'paid';
        $this->save();
        
        return $this;
    }

    /**
     * Scope a query to only include pending commissions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid commissions.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}