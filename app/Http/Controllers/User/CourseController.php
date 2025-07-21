<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CourseController extends Controller
{
    /**
 * Display a listing of the user's courses.
 */
public function index()
{
    $user = Auth::user();
    
    // Get individually purchased courses
    $purchasedCourses = $user->courses;
    
    // Get subscription courses if user has active subscription
    $subscriptionCourses = collect();
    $activeSubscription = User::find(Auth::id())->activeSubscription();
    
    if ($activeSubscription) {
        $subscriptionCourses = $activeSubscription->subscriptionPlan->courses;
    }
    
    // Merge both collections (avoiding duplicates)
    $courses = $purchasedCourses->merge($subscriptionCourses)->unique('id');
    
    return view('user.courses.index', compact('courses'));
}

// UserCourseController.php
public function show(Course $course)
{
    // Check if user has access to the course
    $user = User::find(Auth::id());
    if (!$user || !$user->hasAccessToCourse($course)) {
        return redirect()->route('user.courses.index')
            ->with('error', 'You do not have access to this course.');
    }
    
    $videos = $course->videos()->orderBy('order_number')->get();
    
    // Get progress for each video
    foreach ($videos as $video) {
        $video->progress = $video->userProgress(Auth::id())->first();
    }
    
    // Return the course content view directly
    return view('user.courses.show', compact('course', 'videos'));
}
}