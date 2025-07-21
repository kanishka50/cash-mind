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
        'subscription_assigned'
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'subscription_assigned' => 'boolean',
        'used_at' => 'datetime'
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
}