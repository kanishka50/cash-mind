<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('name', 'id');
        return view('admin.courses.create', compact('categories', 'tags'));
    }

    public function store(CourseRequest $request)
    {
        $data = $request->validated();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        // Create course
        $course = Course::create($data);

        // Sync tags
        if (isset($data['tags'])) {
            $course->tags()->sync($data['tags']);
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('name', 'id');
        $selectedTags = $course->tags->pluck('id')->toArray();
        
        return view('admin.courses.edit', compact('course', 'categories', 'tags', 'selectedTags'));
    }

    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        // Update course
        $course->update($data);

        // Sync tags
        if (isset($data['tags'])) {
            $course->tags()->sync($data['tags']);
        } else {
            $course->tags()->detach();
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        // Delete thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function videos(Course $course)
    {
        $videos = $course->videos()->orderBy('order_number')->get();
        return view('admin.courses.videos', compact('course', 'videos'));
    }
}