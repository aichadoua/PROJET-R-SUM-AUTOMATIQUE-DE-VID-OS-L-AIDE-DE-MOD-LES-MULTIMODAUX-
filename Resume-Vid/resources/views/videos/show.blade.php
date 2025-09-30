@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="max-w-6xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('videos.index') }}"
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium mb-6 transition-colors group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Video Library
                </a>

                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-6">
                    <div class="mb-4 lg:mb-0">
                        <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $video->title }}</h1>
                        <div class="flex items-center space-x-4 text-gray-600">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $video->created_at->format('M d, Y') }}
                            </span>
                            @if($video->updated_at != $video->created_at)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Updated {{ $video->updated_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('videos.edit', $video->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg font-medium transition-colors duration-200 space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit</span>
                        </a>
                        <form action="{{ route('videos.destroy', $video->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure you want to delete this video?')"
                                    class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-medium transition-colors duration-200 space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Video Player Section -->
                <div class="xl:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                        <div class="aspect-video bg-black rounded-t-2xl flex items-center justify-center relative">
                            @if($video->filename)
                                {{-- Case 1: Uploaded video --}}
                                <video controls
                                       class="w-full h-full rounded-t-2xl"
                                       src="{{ asset('storage/' . $video->filename) }}"
                                       poster="/api/placeholder/800/450">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif($video->video_url && Str::contains($video->video_url, 'youtube.com'))
                                {{-- Case 2: YouTube video --}}
                                @php
                                    // Extract the video ID from the YouTube URL
                                    parse_str(parse_url($video->video_url, PHP_URL_QUERY), $youtubeParams);
                                    $videoId = $youtubeParams['v'] ?? null;
                                @endphp

                                @if($videoId)
                                    <iframe class="w-full h-full rounded-t-2xl"
                                            src="https://www.youtube.com/embed/{{ $videoId }}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                    </iframe>
                                @else
                                    <div class="text-center text-white">
                                        <svg class="w-16 h-16 mx-auto mb-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-lg font-semibold text-red-400">Invalid YouTube Link</p>
                                        <p class="text-gray-400">Please check the video URL</p>
                                    </div>
                                @endif
                            @elseif($video->video_url)
                                {{-- Case 3: Direct video URL (e.g., .mp4) --}}
                                <video controls
                                       class="w-full h-full rounded-t-2xl"
                                       src="{{ $video->video_url }}"
                                       poster="/api/placeholder/800/450">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <div class="text-center text-white">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-400">No Video Available</p>
                                    <p class="text-gray-500">This video cannot be displayed</p>
                                </div>
                            @endif
                        </div>

                        <!-- Video Info Panel -->
                        <div class="p-6 border-t border-gray-200">
                            <div class="flex flex-wrap items-center justify-between">
                                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                                    @if($video->filename)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            Uploaded File
                                        </span>
                                    @elseif($video->video_url && Str::contains($video->video_url, 'youtube.com'))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            YouTube
                                        </span>
                                    @elseif($video->video_url)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                            External URL
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center space-x-3">
                                    @if($video->video_url && !Str::contains($video->video_url, 'youtube.com'))
                                        <a href="{{ $video->video_url }}"
                                           target="_blank"
                                           class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            Open Original
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Details Sidebar -->
                <div class="xl:col-span-1 space-y-6">

                    <!-- Summary Card -->
                    @if($video->summary)
                        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6">
                           <div class="download-section">
    @if($video->summary)
        <a href="{{ $video->summary }}"
           class="btn btn-primary "
           download="summary_{{ $video->summary }}"
           target="_blank">
            <i class="fas fa-download"></i> Download Summary
        </a>
    @else
        <span class="text-muted">No download available</span>
    @endif
</div>
                        </div>
                    @else
                        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h2 class="text-xl font-bold text-gray-800">Summary</h2>
                            </div>
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-sm">No summary available</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
