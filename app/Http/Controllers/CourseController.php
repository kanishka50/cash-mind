<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query()->with('category');

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Get courses
        $courses = $query->latest()->paginate(12);
        
        // Get filter options
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('name', 'id');
        
        return view('courses', compact('courses', 'categories', 'tags'));
    }

   public function show($slug)
{
    $course = Course::where('slug', $slug)
        ->with(['category', 'tags'])
        ->firstOrFail();
    
    // Get all videos for display purposes
    $videos = $course->videos()->orderBy('order_number')->get();
        
    // Determine which videos are accessible
    if (Auth::check()) {
        $userOwns = User::find(Auth::id())->courses()->where('courses.id', $course->id)->exists();
    } else {
        $userOwns = false;
    }
    
    // Mark each video as accessible or not
    foreach ($videos as $video) {
        $video->is_accessible = $video->is_preview || $userOwns;
    }
    
    $relatedCourses = Course::where('id', '!=', $course->id)
        ->where(function ($query) use ($course) {
            $query->where('category_id', $course->category_id)
                ->orWhereHas('tags', function ($q) use ($course) {
                    $q->whereIn('tags.id', $course->tags->pluck('id'));
                });
        })
        ->take(4)
        ->get();
        
    return view('course-detail', compact('course', 'videos', 'relatedCourses', 'userOwns'));
}
}