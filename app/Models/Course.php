<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug', 
        'description', 
        'thumbnail', 
        'price', 
        'is_featured', 
        'category_id'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($course) {
            if (!$course->slug) {
                $course->slug = Str::slug($course->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('order_number');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses')
            ->withPivot('purchased_at')
            ->withTimestamps();
    }
    
    public function previewVideo()
    {
        return $this->hasOne(Video::class)->where('is_preview', true);
    }

    public function subscriptionPlans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'subscription_plan_course')
            ->withTimestamps();
    }

    /**
 * Get the commission rate for this course.
 */
public function commissionRate()
{
    return $this->hasOne(CommissionRate::class, 'item_id')
        ->where('item_type', 'course');
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
 * Check if this course has an active commission rate.
 */
public function hasActiveCommissionRate()
{
    return $this->commissionRate()->where('is_active', true)->exists();
}

/**
 * Get the referral links for this course.
 */
public function referralLinks()
{
    return $this->hasMany(ReferralTracking::class, 'item_id')
        ->where('item_type', 'course');
}
}