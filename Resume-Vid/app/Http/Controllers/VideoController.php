<?php
 namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get();
        return view('videos.index', compact('videos'));
    }

    public function create()
    {


        return view('videos.create');
    }
public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'filename' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg',
        'video_url' => 'nullable|url',
    ]);

    if ($request->hasFile('filename')) {
        $path = $request->file('filename')->store('videos', 'public');
        $data['filename'] = $path;
        $data['video_url'] = null; // remove URL if file is uploaded
    } elseif ($request->filled('video_url')) {
        $data['filename'] = null; // remove file path if URL is entered
    } else {
        return back()->with('error', 'Please upload a video file or provide a video URL.');
    }

    Video::create($data);

    return redirect()->route('videos.index')->with('success', 'Video created successfully!');
}


    public function show(Video $video)
    {
        return view('videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        return view('videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $video->update([
            'title' => $request->title,
        ]);

        return redirect()->route('videos.index')->with('success', 'Video updated!');
    }
public  function destroy(Video $video)
{
    // Delete file only if filename exists
    if ($video->filename) {
        Storage::disk('public')->delete($video->filename);
    }

    // Delete summary file if it exists
    if ($video->summary) {
        Storage::disk('public')->delete($video->summary);
    }

    $video->delete();

    return redirect()->route('videos.index')->with('success', 'Video deleted!');
}
    public function summarize(Video $video)
{
    $videoPath = storage_path("app/public/" . $video->filename);

    if (!file_exists($videoPath)) {
        return back()->with('error', 'Video file not found.');
    }

    try {
        // Upload video
        $response = Http::timeout(600)
            ->attach('video', file_get_contents($videoPath), basename($videoPath))
            ->post('https://ba29-35-236-205-81.ngrok-free.app/upload-and-process');

        if ($response->failed() || !$response->json()['success']) {
            return back()->with('error', 'Upload failed.');
        }

        $data = $response->json();
        $video->update([

            'summary' => $data['download_url'],
        ]);

        return back()->with('success', 'Video uploaded for processing. Check status later.');

    } catch (\Exception $e) {
        $video->update(['processing_status' => 'error']);
        return back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}
 public function proxyDownload($fileId)
    {
        $ngrokUrl = "https://ba29-35-236-205-81.ngrok-free.app/result/{$fileId}";
        $response = Http::withHeaders([
            'ngrok-skip-browser-warning' => 'true'
        ])->get($ngrokUrl);

        if ($response->successful()) {
            return response($response->body())
                ->header('Content-Type', $response->header('Content-Type'))
                ->header('Content-Disposition', $response->header('Content-Disposition'));
        }

        return response()->json(['error' => 'File not found'], 404);
    }

}

