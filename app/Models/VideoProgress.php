<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_id',
        'progress_seconds',
        'last_watched',
        'completed'
    ];

    protected $casts = [
        'last_watched' => 'datetime',
        'completed' => 'boolean'
    ];
    
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}