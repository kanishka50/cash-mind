<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    /**
     * Display the user dashboard.
     *
     * @return \Illuminate\View\View
     */
   
   public function index()
    {
        $user = Auth::user();
        
        // Get user's courses with progress
        $courses = User::find(Auth::id())->courses()->latest('user_courses.purchased_at')->take(5)->get();
        foreach ($courses as $course) {
            $totalVideos = $course->videos()->count();
            $watchedVideos = $course->videos()
                ->whereHas('progress', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('completed', true);
                })->count();
                
            $course->progress_percentage = $totalVideos > 0 
                ? round(($watchedVideos / $totalVideos) * 100) 
                : 0;
        }
        
        // Get recent activity
        $recentProgress = User::find(Auth::id())->videoProgress()
            ->with('video.course')
            ->latest('last_watched')
            ->take(5)
            ->get();
            
        return view('user.dashboard.index', compact('courses', 'recentProgress'));
    }


}