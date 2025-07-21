<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'order_id',
        'purchased_at'
    ];

    protected $casts = [
        'purchased_at' => 'datetime'
    ];
    
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // public function order()
    // {
    //     return $this->belongsTo(Order::class);
    // }
}