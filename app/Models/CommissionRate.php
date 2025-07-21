<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_type',
        'item_id',
        'rate',
        'is_active'
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
 * Get the related course
 */
public function course()
{
    return $this->belongsTo(Course::class, 'item_id');
}

   /**
 * Get the related digital product
 */
public function digitalProduct()
{
    return $this->belongsTo(DigitalProduct::class, 'item_id');
}

    /**
     * Get the related model regardless of type
     */
    public function getItemAttribute()
    {
        return $this->item_type === 'course' 
            ? $this->course 
            : $this->digitalProduct;
    }

    /**
     * Scope a query to only include active commission rates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}