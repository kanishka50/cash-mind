<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Support\Facades\Log;

class VideoService
{
    /**
     * Upload a video file and return the file path
     */
    public function uploadVideo(UploadedFile $video): string
    {
        // Store video in private storage (for security)
        $path = $video->store('videos', 'private');
        
        // Also store preview in public storage if needed
        if ($video->isValid()) {
            // You could also create a thumbnail here
            // or make a preview version with watermark
        }
        
        return $path;
    }
    
    /**
     * Delete a video from storage
     */
    public function deleteVideo(string $path): bool
    {
        return Storage::disk('private')->delete($path);
    }
    
    /**
     * Get video duration in seconds
     * Note: Requires FFmpeg to be installed
     */
    public function getVideoDuration(string $path): ?int
    {
        try {
            // Simple implementation without FFmpeg
            $fullPath = Storage::disk('private')->path($path);
            $getID3 = new \getID3;
            $fileInfo = $getID3->analyze($fullPath);
            
            if (isset($fileInfo['playtime_seconds'])) {
                return (int) $fileInfo['playtime_seconds'];
            }
            
            // Alternative with FFMpeg if installed
            /*
            $ffprobe = FFProbe::create();
            $duration = $ffprobe
                ->format(Storage::disk('private')->path($path))
                ->get('duration');
                
            return (int) $duration;
            */
            
            return null;
        } catch (\Exception $e) {
            // Log error
            Log::error('Failed to get video duration: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Stream video content with proper headers
     */
    public function streamVideo(string $path)
    {
        $file = Storage::disk('private')->path($path);
        $stream = new \Symfony\Component\HttpFoundation\StreamedResponse(function() use ($file) {
            $stream = fopen($file, 'rb');
            fpassthru($stream);
            fclose($stream);
        });
        
        $stream->headers->set('Content-Type', 'video/mp4');
        $stream->headers->set('Content-Length', Storage::disk('private')->size($path));
        $stream->headers->set('Accept-Ranges', 'bytes');
        
        return $stream;
    }
}