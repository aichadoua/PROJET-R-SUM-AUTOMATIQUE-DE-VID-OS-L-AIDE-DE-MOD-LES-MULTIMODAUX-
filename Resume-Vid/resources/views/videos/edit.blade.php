@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">Edit Video</h1>

    <form action="{{ route('videos.update', $video->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Title</label>
            <input type="text" name="title" class="w-full border rounded p-2" value="{{ $video->title }}" required>
        </div>

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
