<?php

namespace App\Http\Controllers;

use App\Models\AudioTrack;
use App\Models\BellSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function index()
    {
        $tracks    = AudioTrack::latest()->get();
        $schedules = BellSchedule::orderBy('time')->get();
        return view('audio', compact('tracks', 'schedules'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'audio_file' => 'required|file|mimes:mp3,wav|max:10240',
        ]);

        $file     = $request->file('audio_file');
        $fileName = $file->getClientOriginalName();
        $path     = $file->store('audio', 'public');

        AudioTrack::create([
            'file_name' => $fileName,
            'file_path' => $path,
            'duration'  => null,
        ]);

        return redirect()->route('audio')->with('success', 'Audio berhasil diupload.');
    }

    public function destroy(AudioTrack $audioTrack)
    {
        Storage::disk('public')->delete($audioTrack->file_path);
        $audioTrack->delete();
        return redirect()->route('audio')->with('success', 'Audio berhasil dihapus.');
    }
}
