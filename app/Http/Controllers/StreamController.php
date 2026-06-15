<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class StreamController extends Controller
{
    public function stream(Request $request)
    {
        $path = storage_path('app/public/streams/output.m3u8'); // Path to the HLS playlist
        if (!file_exists($path)) {
            abort(404, 'Stream not found.');
        }

        return response()->file($path, [
            'Content-Type' => 'application/vnd.apple.mpegurl',
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,mkv,avi,flv|max:500000',
        ]);

        // Store the uploaded video
        $path = $request->file('video')->store('public/videos');
        $videoPath = Storage::path($path);

        // Define output directory for HLS segments
        $outputDir = storage_path('app/public/hls/' . pathinfo($videoPath, PATHINFO_FILENAME));
        mkdir($outputDir, 0755, true);

        // Run FFmpeg to convert video into HLS format
        $process = new Process([
            'ffmpeg',
            '-i',
            $videoPath,
            '-c:v',
            'libx264',
            '-hls_time',
            '10',
            '-hls_list_size',
            '0',
            '-f',
            'hls',
            $outputDir . '/stream.m3u8'
        ]);

        $process->run();

        // Check if the process failed
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json(['message' => 'Video uploaded and converted successfully!', 'playlist_url' => asset('storage/hls/' . pathinfo($videoPath, PATHINFO_FILENAME) . '/stream.m3u8')]);
    }
}
