<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'total_earned'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'total_earned' => 'decimal:2',
    ];

    /**
     * Get the user that owns the commission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the earnings for this user commission.
     */
    public function earnings()
    {
        return $this->hasMany(CommissionEarning::class, 'user_id', 'user_id');
    }

    /**
     * Get the payout requests for this user commission.
     */
    public function payoutRequests()
    {
        return $this->hasMany(PayoutRequest::class, 'user_id', 'user_id');
    }

    /**
     * Add to the user's commission balance and total earned.
     */
    public function addCommission($amount)
    {
        $this->balance += $amount;
        $this->total_earned += $amount;
        $this->save();
        
        return $this;
    }

    /**
     * Deduct from the user's commission balance.
     */
    public function deductBalance($amount)
    {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            $this->save();
            return true;
        }
        
        return false;
    }
}