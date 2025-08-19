<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'order_id',
        'subscription_id',
        'access_type',      // NEW
        'expires_at',       // NEW
        'purchased_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'purchased_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'subscription_id');
    }

    // Check if access is valid
    public function isValid()
    {
        // Purchased items are always valid
        if ($this->access_type === 'purchased') {
            return true;
        }
        
        // Subscription items check expiry
        return $this->expires_at === null || $this->expires_at->isFuture();
    }

    // Scope for valid access
    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->where('access_type', 'purchased')
              ->orWhere(function ($sub) {
                  $sub->where('access_type', 'subscription')
                      ->where(function ($exp) {
                          $exp->whereNull('expires_at')
                              ->orWhere('expires_at', '>', now());
                      });
              });
        });
    }

    // Scope for expired access
    public function scopeExpired($query)
    {
        return $query->where('access_type', 'subscription')
                     ->where('expires_at', '<=', now());
    }
}