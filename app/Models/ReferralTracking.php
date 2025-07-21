<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralTracking extends Model
{
    use HasFactory;

    protected $table = 'referral_tracking';

    protected $fillable = [
        'referrer_id',
        'referral_code',
        'item_type',
        'item_id',
        'clicks',
        'conversions'
    ];

    /**
     * Get the referrer user.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the related course if item_type is 'course'.
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
     */
    public function digitalProduct()
    {
        if ($this->item_type === 'digital_product') {
            return $this->belongsTo(DigitalProduct::class, 'item_id');
        }
        return null;
    }

    /**
     * Get the related item regardless of type.
     */
    public function getItemAttribute()
    {
        return $this->item_type === 'course' 
            ? $this->course 
            : $this->digitalProduct;
    }

    /**
     * Increment the click counter.
     */
    public function incrementClicks()
    {
        $this->increment('clicks');
        return $this;
    }

    /**
     * Increment the conversion counter.
     */
    public function incrementConversions()
    {
        $this->increment('conversions');
        return $this;
    }
}