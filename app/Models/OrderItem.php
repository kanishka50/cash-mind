<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_type',
        'item_id',
        'item_name',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the order that owns the item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the item as a polymorphic relation.
     */
    public function item()
    {
        if ($this->item_type === 'course') {
            return $this->belongsTo(Course::class, 'item_id');
        } elseif ($this->item_type === 'digital_product') {
            return $this->belongsTo(DigitalProduct::class, 'item_id');
        }
        
        return null;
    }

    /**
     * Get the total price for this item.
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}