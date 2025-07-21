<div class="video-player bg-darker rounded-lg shadow-xl overflow-hidden border border-gray-800">
    <video
        id="videoPlayer"
        class="w-full"
        controls
        poster="{{ $poster ?? '' }}"
        data-video-id="{{ $video->id }}"
        data-progress="{{ $progress->progress_seconds ?? 0 }}"
        data-completed="{{ $progress->completed ?? 0 }}"
        data-update-url="{{ route('user.videos.progress', $video) }}"
    >
        <source src="{{ route('video.stream', $video) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    
    <div class="bg-card p-4 border-t border-gray-800">
        <div class="flex justify-between items-center">
            <div class="w-full mr-4">
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-gray-400">Progress</span>
                    <span id="progress-percentage" class="text-xs text-accent-teal">0%</span>
                </div>
                <div class="relative">
                    <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-800">
                        <div id="progress-bar" style="width: 0%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-accent-teal transition-all duration-300"></div>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <button id="playbackSpeed" class="text-sm text-gray-300 bg-darker hover:bg-gray-700 px-3 py-1.5 rounded-md transition-colors duration-200 border border-gray-800">
                    1.0x
                </button>
                <button id="toggleFullscreen" class="text-sm text-gray-300 bg-darker hover:bg-gray-700 px-3 py-1.5 rounded-md transition-colors duration-200 border border-gray-800 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const videoPlayer = document.getElementById('videoPlayer');
        const progressBar = document.getElementById('progress-bar');
        const progressPercentage = document.getElementById('progress-percentage');
        const playbackSpeedBtn = document.getElementById('playbackSpeed');
        const toggleFullscreenBtn = document.getElementById('toggleFullscreen');
        
        const videoId = videoPlayer.dataset.videoId;
        const initialProgress = parseInt(videoPlayer.dataset.progress);
        const completed = videoPlayer.dataset.completed === '1';
        const updateUrl = videoPlayer.dataset.updateUrl;
        
        let lastUpdateTime = 0;
        let playbackSpeeds = [0.5, 0.75, 1.0, 1.25, 1.5, 1.75, 2.0];
        let currentSpeedIndex = 2; // Default 1.0x
        
        // Set initial progress
        if (initialProgress > 0) {
            videoPlayer.currentTime = initialProgress;
        }
        
        // Update progress bar
        videoPlayer.addEventListener('timeupdate', function() {
            const currentTime = Math.floor(videoPlayer.currentTime);
            const duration = Math.floor(videoPlayer.duration);
            
            // Update progress bar
            const percentage = (currentTime / duration) * 100;
            progressBar.style.width = percentage + '%';
            progressPercentage.textContent = Math.round(percentage) + '%';
            
            // Only update every 5 seconds to avoid too many requests
            if (currentTime - lastUpdateTime >= 5) {
                lastUpdateTime = currentTime;
                
                // Mark as completed if 95% watched
                const isCompleted = (currentTime / duration) >= 0.95;
                
                updateProgress(currentTime, isCompleted);
            }
        });
        
        // Mark as completed if video ends
        videoPlayer.addEventListener('ended', function() {
            updateProgress(videoPlayer.duration, true);
            progressBar.style.width = '100%';
            progressPercentage.textContent = '100%';
        });
        
        // Playback speed control
        playbackSpeedBtn.addEventListener('click', function() {
            currentSpeedIndex = (currentSpeedIndex + 1) % playbackSpeeds.length;
            const newSpeed = playbackSpeeds[currentSpeedIndex];
            videoPlayer.playbackRate = newSpeed;
            playbackSpeedBtn.textContent = newSpeed + 'x';
        });
        
        // Fullscreen toggle
        toggleFullscreenBtn.addEventListener('click', function() {
            if (videoPlayer.requestFullscreen) {
                videoPlayer.requestFullscreen();
            } else if (videoPlayer.webkitRequestFullscreen) { /* Safari */
                videoPlayer.webkitRequestFullscreen();
            } else if (videoPlayer.msRequestFullscreen) { /* IE11 */
                videoPlayer.msRequestFullscreen();
            }
        });
        
        function updateProgress(progressSeconds, isCompleted) {
            fetch(updateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    progress_seconds: progressSeconds,
                    completed: isCompleted
                })
            })
            .catch(error => console.error('Error updating progress:', error));
        }
    });
</script>
@endpush