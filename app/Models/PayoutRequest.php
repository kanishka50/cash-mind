<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'payment_method',
        'payment_details',
        'status',
        'admin_notes',
        'processed_by',
        'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'json',
        'processed_at' => 'datetime'
    ];

    /**
     * Get the user that requested the payout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin user who processed the payout.
     */
    public function processedByUser()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Mark this payout request as paid.
     */
    public function markAsPaid($adminId, $notes = null)
    {
        $this->status = 'paid';
        $this->processed_by = $adminId;
        $this->processed_at = now();
        
        if ($notes) {
            $this->admin_notes = $notes;
        }
        
        $this->save();
        
        // Update the user's commission balance
        $userCommission = UserCommission::where('user_id', $this->user_id)->first();
        if ($userCommission) {
            $userCommission->deductBalance($this->amount);
        }
        
        return $this;
    }

    /**
     * Mark this payout request as rejected.
     */
    public function markAsRejected($adminId, $notes)
    {
        $this->status = 'rejected';
        $this->processed_by = $adminId;
        $this->processed_at = now();
        $this->admin_notes = $notes;
        $this->save();
        
        return $this;
    }

    /**
     * Scope a query to only include pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid requests.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include rejected requests.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}