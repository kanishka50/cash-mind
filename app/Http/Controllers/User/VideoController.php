<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VideoController extends Controller
{
    public function show(Video $video)
{
    $user = User::find(Auth::id());
    
    // Check if video is a preview
    $isPreview = $video->is_preview;
    
    // Check if user has access to the course (either by purchase or subscription)
    $hasAccess = $user->hasAccessToCourse($video->course);
    
    if (!$isPreview && !$hasAccess) {
        return redirect()->route('courses.show', $video->course->slug)
            ->with('error', 'You do not have access to this video.');
    }
    
    // Get user progress
    $progress = VideoProgress::firstOrCreate(
        ['user_id' => Auth::id(), 'video_id' => $video->id],
        ['progress_seconds' => 0, 'completed' => false]
    );
    
    // Get course videos
    $courseVideos = $video->course->videos()->orderBy('order_number')->get();
    
    // Get next and previous videos
    $currentIndex = $courseVideos->search(function ($item) use ($video) {
        return $item->id === $video->id;
    });
    
    $previousVideo = $currentIndex > 0 ? $courseVideos[$currentIndex - 1] : null;
    $nextVideo = $currentIndex < $courseVideos->count() - 1 ? $courseVideos[$currentIndex + 1] : null;
    
    return view('user.videos.show', compact('video', 'progress', 'courseVideos', 'previousVideo', 'nextVideo'));
}
    
    public function updateProgress(Request $request, Video $video)
    {
        $validated = $request->validate([
            'progress_seconds' => 'required|integer|min:0',
            'completed' => 'sometimes|boolean'
        ]);
        
        $progress = VideoProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'video_id' => $video->id],
            [
                'progress_seconds' => $validated['progress_seconds'],
                'completed' => $validated['completed'] ?? false,
                'last_watched' => now()
            ]
        );
        
        return response()->json(['success' => true]);
    }
}