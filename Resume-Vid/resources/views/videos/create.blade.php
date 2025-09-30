@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('videos.index') }}"
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium mb-4 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Video Library
                </a>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Upload New Video</h1>
                <p class="text-gray-600">Add a new video to your collection by uploading a file or providing a URL</p>
            </div>

            <!-- Main Upload Form -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <!-- Title Input -->
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">
                                Video Title
                            </label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   value="{{ old('title') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-50 transition-all duration-200 text-lg @error('title') border-red-500 @enderror"
                                   placeholder="Enter a descriptive title for your video"
                                   required>
                            @error('title')
                                <p class="text-red-600 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Upload Options -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Choose Upload Method</h3>
                                <p class="text-gray-600">Select how you'd like to add your video</p>
                            </div>

                            <!-- File Upload Option -->
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <input type="radio"
                                           name="upload_method"
                                           id="file_upload"
                                           value="file"
                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                           checked>
                                    <label for="file_upload" class="text-lg font-medium text-gray-700">Upload Video File</label>
                                </div>

                                <div id="file_upload_section" class="ml-7 space-y-3">
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors duration-200 bg-gray-50">
                                        <div class="space-y-4">
                                            <div class="flex justify-center">
                                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <label for="filename" class="cursor-pointer">
                                                    <span class="text-lg font-medium text-blue-600 hover:text-blue-500">Click to upload</span>
                                                    <span class="text-gray-500"> or drag and drop</span>
                                                </label>
                                                <p class="text-sm text-gray-500 mt-1">MP4, AVI, MOV up to 500MB</p>
                                            </div>
                                            <input type="file"
                                                   name="filename"
                                                   id="filename"
                                                   accept="video/*"
                                                   class="hidden"
                                                   onchange="displayFileName(this)">
                                        </div>
                                    </div>
                                    <div id="file_display" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                <div>
                                                    <p class="font-medium text-gray-800" id="file_name"></p>
                                                    <p class="text-sm text-gray-600" id="file_size"></p>
                                                </div>
                                            </div>
                                            <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @error('filename')
                                        <p class="text-red-600 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- URL Upload Option -->
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <input type="radio"
                                           name="upload_method"
                                           id="url_upload"
                                           value="url"
                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="url_upload" class="text-lg font-medium text-gray-700">Enter Video URL</label>
                                </div>

                                <div id="url_upload_section" class="ml-7 space-y-3 hidden">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                        </div>
                                        <input type="url"
                                               name="video_url"
                                               id="video_url"
                                               value="{{ old('video_url') }}"
                                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-50 transition-all duration-200 @error('video_url') border-red-500 @enderror"
                                               placeholder="https://example.com/video.mp4">
                                    </div>
                                    <p class="text-sm text-gray-500">Enter a direct link to your video file</p>
                                    @error('video_url')
                                        <p class="text-red-600 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
                                <a href="{{ route('videos.index') }}"
                                   class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span>Upload Video</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-2xl p-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-blue-800 mb-2">Upload Guidelines</h3>
                        <ul class="text-blue-700 space-y-1 text-sm">
                            <li>• Supported formats: MP4, AVI, MOV, WMV</li>
                            <li>• Maximum file size: 500MB</li>
                            <li>• For URLs: Use direct links to video files</li>
                            <li>• Choose descriptive titles for better organization</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle between upload methods
document.querySelectorAll('input[name="upload_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const fileSection = document.getElementById('file_upload_section');
        const urlSection = document.getElementById('url_upload_section');

        if (this.value === 'file') {
            fileSection.classList.remove('hidden');
            urlSection.classList.add('hidden');
            document.getElementById('video_url').removeAttribute('required');
            document.getElementById('filename').setAttribute('required', '');
        } else {
            fileSection.classList.add('hidden');
            urlSection.classList.remove('hidden');
            document.getElementById('filename').removeAttribute('required');
            document.getElementById('video_url').setAttribute('required', '');
        }
    });
});

// Display selected file information
function displayFileName(input) {
    const fileDisplay = document.getElementById('file_display');
    const fileName = document.getElementById('file_name');
    const fileSize = document.getElementById('file_size');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileDisplay.classList.remove('hidden');
    }
}

// Clear selected file
function clearFile() {
    document.getElementById('filename').value = '';
    document.getElementById('file_display').classList.add('hidden');
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Drag and drop functionality
const dropZone = document.querySelector('.border-dashed');
const fileInput = document.getElementById('filename');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-blue-400', 'bg-blue-50');
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-400', 'bg-blue-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-400', 'bg-blue-50');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        displayFileName(fileInput);
    }
});
</script>
@endsection
