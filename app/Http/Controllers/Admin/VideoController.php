<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VideoRequest;
use App\Models\Course;
use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index()
    {
        $videos = Video::with('course')->latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $courses = Course::pluck('title', 'id');
        return view('admin.videos.create', compact('courses'));
    }

    public function store(VideoRequest $request)
    {
        $data = $request->validated();

        // Check if this is a chunked upload completion
        if ($request->has('uploaded_file_path')) {
            $data['file_path'] = $request->uploaded_file_path;
            
            // Get duration if not provided
            if (empty($data['duration'])) {
                $data['duration'] = $this->videoService->getVideoDuration($data['file_path']);
            }
        } elseif ($request->hasFile('video')) {
            // Regular upload for smaller files
            $data['file_path'] = $this->videoService->uploadVideo($request->file('video'));
            
            // Get duration if not provided
            if (empty($data['duration'])) {
                $data['duration'] = $this->videoService->getVideoDuration($data['file_path']);
            }
        }

        Video::create($data);

        return redirect()->route('admin.courses.videos', $data['course_id'])
            ->with('success', 'Video created successfully.');
    }

    public function edit(Video $video)
    {
        $courses = Course::pluck('title', 'id');
        return view('admin.videos.edit', compact('video', 'courses'));
    }

    public function update(VideoRequest $request, Video $video)
    {
        $data = $request->validated();

        // Check if this is a chunked upload completion
        if ($request->has('uploaded_file_path')) {
            // Delete old video
            $this->videoService->deleteVideo($video->file_path);
            
            $data['file_path'] = $request->uploaded_file_path;
            
            // Get duration if not provided
            if (empty($data['duration'])) {
                $data['duration'] = $this->videoService->getVideoDuration($data['file_path']);
            }
        } elseif ($request->hasFile('video')) {
            // Delete old video
            $this->videoService->deleteVideo($video->file_path);
            
            // Upload new video
            $data['file_path'] = $this->videoService->uploadVideo($request->file('video'));
            
            // Get duration if not provided
            if (empty($data['duration'])) {
                $data['duration'] = $this->videoService->getVideoDuration($data['file_path']);
            }
        }

        $video->update($data);

        return redirect()->route('admin.courses.videos', $video->course_id)
            ->with('success', 'Video updated successfully.');
    }

    public function destroy(Video $video)
    {
        $courseId = $video->course_id;
        
        // Delete video file
        $this->videoService->deleteVideo($video->file_path);
        
        $video->delete();

        return redirect()->route('admin.courses.videos', $courseId)
            ->with('success', 'Video deleted successfully.');
    }

    /**
     * Handle chunked video upload
     */
    public function uploadChunk(Request $request)
    {
        $request->validate([
            'chunk' => 'required|file',
            'chunkIndex' => 'required|integer',
            'totalChunks' => 'required|integer',
            'uploadId' => 'required|string',
            'fileName' => 'required|string'
        ]);

        $uploadId = $request->uploadId;
        $chunkIndex = $request->chunkIndex;
        
        // Store chunk temporarily
        $chunkPath = "temp/chunks/{$uploadId}/chunk_{$chunkIndex}";
        Storage::disk('local')->put($chunkPath, $request->file('chunk')->get());

        return response()->json([
            'success' => true,
            'message' => "Chunk {$chunkIndex} uploaded successfully"
        ]);
    }

    /**
     * Complete the chunked upload by merging all chunks
     */
    public function completeUpload(Request $request)
    {
        $request->validate([
            'uploadId' => 'required|string',
            'fileName' => 'required|string',
            'totalChunks' => 'required|integer'
        ]);

        $uploadId = $request->uploadId;
        $fileName = $request->fileName;
        $totalChunks = $request->totalChunks;

        // Generate final file path
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $finalFileName = time() . '_' . uniqid() . '.' . $extension;
        $finalPath = 'videos/' . $finalFileName;

        // Create the final file in private storage
        $finalFullPath = Storage::disk('private')->path($finalPath);
        $finalDirectory = dirname($finalFullPath);
        
        // Ensure directory exists
        if (!file_exists($finalDirectory)) {
            mkdir($finalDirectory, 0755, true);
        }

        // Open file for writing
        $finalFile = fopen($finalFullPath, 'wb');

        // Merge chunks
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = "temp/chunks/{$uploadId}/chunk_{$i}";
            $chunkContent = Storage::disk('local')->get($chunkPath);
            
            fwrite($finalFile, $chunkContent);
            
            // Delete chunk after merging
            Storage::disk('local')->delete($chunkPath);
        }

        fclose($finalFile);

        // Clean up temp directory
        Storage::disk('local')->deleteDirectory("temp/chunks/{$uploadId}");

        return response()->json([
            'success' => true,
            'filePath' => $finalPath,
            'message' => 'Upload completed successfully'
        ]);
    }
}