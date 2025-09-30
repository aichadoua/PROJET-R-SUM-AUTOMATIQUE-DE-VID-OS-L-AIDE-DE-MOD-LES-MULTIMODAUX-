@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border border-slate-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Video Library</h1>
                    <p class="text-gray-600">Manage and organize your video collection</p>
                </div>
                <a href="{{ route('videos.create') }}"
                   class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Upload New Video</span>
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-xl mb-8 shadow-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Videos Grid/Table -->
        @if($videos->isEmpty())
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center border border-slate-200">
                <div class="mb-6">
                    <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-4">No videos uploaded yet</h3>
                <p class="text-gray-500 mb-8">Start building your video library by uploading your first video.</p>
                <a href="{{ route('videos.create') }}"
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    Upload Your First Video
                </a>
            </div>
        @else
            <!-- Desktop Table View -->
            <div class="hidden md:block bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    Video Title
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($videos as $video)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900">{{ $video->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $video->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('videos.show', $video->id) }}"
                                           class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span>View</span>
                                        </a>
                                        <a href="{{ route('videos.edit', $video->id) }}"
                                           class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                        @if($video->summary)
                                              @if($video->summary)
    @php
        $lastUpdated = \Carbon\Carbon::parse($video->updated_at);
        $fiveMinutesAgo = \Carbon\Carbon::now()->subMinutes(5);
        $isOlderThanFiveMinutes = $lastUpdated->lt($fiveMinutesAgo);
    @endphp

    @if($isOlderThanFiveMinutes)
        {{-- Show direct download link if updated more than 5 minutes ago --}}
        <a href="{{$video->summary}}"
           class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
           download>
            <i class="fas fa-download"></i> Download Summary
        </a>
    @else
        {{-- Show processing button if updated within last 5 minutes --}}
        <a href="#" id="summary-btn-{{ $video->id }}"
           class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
           data-video-id="{{ $video->id }}"
           data-summary-url="/proxy-download/{{ basename($video->summary) }}"
          data-download-url="{{ $video->summary }}"

           >
            <i class="fas fa-spinner fa-spin"></i> Processing...
        </a>
    @endif
@endif
                                            @else

                                         <form action="{{ route('videos.summarize', $video->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                        <button type="submit"
                                                class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                                        Summarize
                                        </button>
                                        </form>                                            @endif

                                        <form action="{{ route('videos.destroy', $video->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure you want to delete this video?')"
                                                    class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4">
                @foreach ($videos as $video)
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center flex-1">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $video->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $video->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('videos.show', $video->id) }}"
                               class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                View
                            </a>
                            <a href="{{ route('videos.edit', $video->id) }}"
                               class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                Edit
                            </a>
                            <form action="{{ route('videos.summarize', $video->id) }}" method="POST" style="display:inline;">
                                 @csrf
                           <button type="submit"
                                 class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                         Summarize
                        </button>
                              </form>
                            <form action="{{ route('videos.destroy', $video->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure you want to delete this video?')"
                                        class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        <!-- Pagination (if applicable) -->
        @if(method_exists($videos, 'links'))
            <div class="mt-8">
                {{ $videos->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    function checkVideoStatus(videoId, summaryUrl , downloadUrl) {
    const button = document.getElementById(`summary-btn-${videoId}`);

    // Make AJAX request to check status
   fetch(summaryUrl, {
    method: 'GET',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'ngrok-skip-browser-warning': 'true',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
.then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success ==true  ) {
 // Video is ready - update button for download
            button.innerHTML = '<i class="fas fa-download"></i> Download Summary';
            button.href = downloadUrl;
            button.setAttribute('download', `summary_${videoId}`);
            button.setAttribute('target', '_blank');

            // Remove click prevention
            button.onclick = null;

         } else {
     // Video still processing - keep showing processing state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            button.href = '#';
            button.removeAttribute('download');
            button.removeAttribute('target');

            // Check again after 10 seconds
            setTimeout(() => checkVideoStatus(videoId, summaryUrl , downloadUrl), 10000);




        }
    })
    .catch(error => {
        console.error('Error checking video status:', error);
        // Retry after 10 seconds even on error
        setTimeout(() => checkVideoStatus(videoId, summaryUrl , downloadUrl), 10000);
    });
}

// Initialize status checking when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Find all summary buttons and start checking their status
    const summaryButtons = document.querySelectorAll('[id^="summary-btn-"]');

    summaryButtons.forEach(button => {
        const videoId = button.getAttribute('data-video-id');
        const summaryUrl = button.getAttribute('data-summary-url');
        const downloadUrl = button.getAttribute('data-download-url');

        // Prevent default click behavior while processing
        button.onclick = function(e) {
            e.preventDefault();
            return false;
        };

        // Start status checking
        checkVideoStatus(videoId, summaryUrl , downloadUrl);
    });
});

// Alternative approach if you want to manually trigger for a specific video
function initializeVideoStatusCheck(videoId, summaryUrl) {
    const button = document.getElementById(`summary-btn-${videoId}`);

    // Set initial processing state
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    button.href = '#';
    button.onclick = function(e) {
        e.preventDefault();
        return false;
    };

    // Start checking
    checkVideoStatus(videoId, summaryUrl);
}
</script>
@endsection
