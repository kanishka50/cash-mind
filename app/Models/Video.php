<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'file_path',
        'duration',
        'order_number',
        'is_preview'
    ];

    // Add this line to allow setting is_accessible
    protected $appends = ['is_accessible'];
    
    // Define accessor for is_accessible
    public function getIsAccessibleAttribute()
    {
        return $this->attributes['is_accessible'] ?? false;
    }
    
    // Define mutator for is_accessible
    public function setIsAccessibleAttribute($value)
    {
        $this->attributes['is_accessible'] = $value;
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progress()
    {
        return $this->hasMany(VideoProgress::class);
    }
    
    public function userProgress($userId)
    {
        return $this->hasOne(VideoProgress::class)->where('user_id', $userId);
    }
}