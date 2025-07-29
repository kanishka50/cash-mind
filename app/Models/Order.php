<?php
// ===== Order.php =====
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'discount_amount',
        'final_amount',
        'payment_status',
        'payment_method',
        'payment_id',
        'coupon_id',
        'notes',
        // New fields for manual payment
        'payment_receipt',
        'payment_receipt_uploaded_at',
        'payment_verified_by',
        'payment_verified_at',
        'admin_notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'payment_receipt_uploaded_at' => 'datetime',
        'payment_verified_at' => 'datetime',
    ];

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber()
    {
        $prefix = 'CM-';
        $timestamp = now()->format('Ymd');
        $randomString = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        
        return $prefix . $timestamp . '-' . $randomString;
    }

    /**
     * Get the user who made the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who verified the payment.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'payment_verified_by');
    }

    /**
     * Get the coupon used for this order.
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the items for this order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get courses purchased in this order.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'order_items', 'order_id', 'item_id')
            ->where('item_type', 'course');
    }

    /**
     * Get digital products purchased in this order.
     */
    public function digitalProducts()
    {
        return $this->belongsToMany(DigitalProduct::class, 'order_items', 'order_id', 'item_id')
            ->where('item_type', 'digital_product');
    }

    /**
     * Check if this order has a specific item.
     */
    public function hasItem($itemId, $itemType)
    {
        return $this->orderItems()
            ->where('item_id', $itemId)
            ->where('item_type', $itemType)
            ->exists();
    }

    /**
     * Check if the order is completed.
     */
    public function isCompleted()
    {
        return $this->payment_status === 'completed';
    }

    /**
     * Check if the order is pending.
     */
    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if the order has failed.
     */
    public function hasFailed()
    {
        return $this->payment_status === 'failed';
    }

    /**
     * Check if the order has been refunded.
     */
    public function isRefunded()
    {
        return $this->payment_status === 'refunded';
    }

    /**
     * Check if order has payment receipt uploaded.
     */
    public function hasPaymentReceipt()
    {
        return !empty($this->payment_receipt);
    }

    /**
     * Check if order is awaiting payment verification.
     */
    public function isAwaitingVerification()
    {
        return $this->hasPaymentReceipt() && $this->isPending();
    }

    /**
     * Mark order as verified by admin.
     */
    public function markAsVerified($adminId)
    {
        $this->update([
            'payment_status' => 'completed',
            'payment_verified_by' => $adminId,
            'payment_verified_at' => now(),
        ]);
    }

    /**
     * Get the payment receipt URL.
     */
    public function getPaymentReceiptUrl()
    {
        if (!$this->payment_receipt) {
            return null;
        }
        
        return route('admin.orders.receipt', $this);
    }

    /**
     * Scope a query to only include completed orders.
     */
    public function scopeCompleted($query)
    {
        return $query->where('payment_status', 'completed');
    }

    /**
     * Scope a query to only include orders with pending receipts.
     */
    public function scopePendingReceipts($query)
    {
        return $query->whereNotNull('payment_receipt')
                    ->where('payment_status', 'pending');
    }

    /**
     * Scope a query to only include orders from a specific period.
     */
    public function scopeFromPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Calculate any dynamic properties.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            // Generate a unique order number if not provided
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
        });
    }
}