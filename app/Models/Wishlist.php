<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wishlist_type',
        'item_id',
    ];

    /**
     * Indicates if the model has timestamps.
     * If your table doesn't have created_at and updated_at columns, set this to false.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the user that owns the wishlist item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related item based on wishlist_type.
     * This is a dynamic relationship.
     */
    public function item()
    {
        if ($this->wishlist_type === 'course') {
            return $this->belongsTo(Course::class, 'item_id');
        } elseif ($this->wishlist_type === 'digital_product') {
            return $this->belongsTo(DigitalProduct::class, 'item_id');
        }
        
        return null;
    }
}