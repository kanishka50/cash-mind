<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_monthly',
        'price_yearly',
    ];

    /**
     * Get the users with this subscription plan.
     */
    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Get the courses included in this subscription plan.
     */
    public function courses()
{
    return $this->belongsToMany(Course::class, 'subscription_plan_course')
        ->withTimestamps();
}

    /**
     * Get the digital products included in this subscription plan.
     */
   public function digitalProducts()
{
    return $this->belongsToMany(DigitalProduct::class, 'subscription_plan_digital_product')
        ->withTimestamps();
}

    /**
     * Get the active subscribers count.
     */
    public function getActiveSubscribersCountAttribute()
    {
        return $this->userSubscriptions()->where('is_active', true)->count();
    }
}