<?php

namespace App\Http\Controllers;

use App\Models\AudioTrack;
use App\Models\BellSchedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $dayFilter = $request->query('day', 'All Days');
        $days      = ['All Days', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $dayMap    = ['Monday'=>'Mon','Tuesday'=>'Tue','Wednesday'=>'Wed','Thursday'=>'Thu','Friday'=>'Fri','Saturday'=>'Sat','Sunday'=>'Sun'];

        $query = BellSchedule::orderBy('time');

        if ($dayFilter !== 'All Days' && isset($dayMap[$dayFilter])) {
            $query->whereJsonContains('days', $dayMap[$dayFilter]);
        }

        $schedules   = $query->get();

        $dbTracks    = AudioTrack::pluck('file_name')->toArray();
        $usedTracks  = BellSchedule::pluck('audio_file')->unique()->toArray();
        $audioTracks = collect(array_unique(array_merge($dbTracks, $usedTracks)))->sort()->values();

        return view('schedule', compact('schedules', 'days', 'dayFilter', 'audioTracks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'time'       => 'required',
            'meridiem'   => 'required|in:AM,PM',
            'days'       => 'required|array',
            'audio_file' => 'required|string',
            'status'     => 'required|in:Active,Inactive',
        ]);

        BellSchedule::create($data);
        return redirect()->route('schedule')->with('success', 'Jadwal bel berhasil ditambahkan.');
    }

    public function update(Request $request, BellSchedule $bellSchedule)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'time'       => 'required',
            'meridiem'   => 'required|in:AM,PM',
            'days'       => 'required|array',
            'audio_file' => 'required|string',
            'status'     => 'required|in:Active,Inactive',
        ]);

        $bellSchedule->update($data);
        return redirect()->route('schedule')->with('success', 'Jadwal bel berhasil diperbarui.');
    }

    public function destroy(BellSchedule $bellSchedule)
    {
        $bellSchedule->delete();
        return redirect()->route('schedule')->with('success', 'Jadwal bel berhasil dihapus.');
    }

    public function toggleStatus(BellSchedule $bellSchedule)
    {
        $bellSchedule->update([
            'status' => $bellSchedule->status === 'Active' ? 'Inactive' : 'Active',
        ]);
        return redirect()->route('schedule')->with('success', 'Status jadwal diperbarui.');
    }
}
