<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
   public function index()
    {
        $stats = [
            'total_users' => User::where('is_admin', false)->count(),
            'total_courses' => Course::count(),
            'total_videos' => Video::count(),
            'featured_courses' => Course::where('is_featured', true)->count(),
        ];

        $latest_courses = Course::latest()->take(5)->get();
        $latest_users = User::where('is_admin', false)->latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'latest_courses', 'latest_users'));
    }
}