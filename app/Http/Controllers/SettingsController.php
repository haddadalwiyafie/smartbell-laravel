<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $setting  = Setting::instance();
        $admin    = Auth::user();
        $activity = ActivityLog::latest()->take(10)->get();
        return view('settings', compact('setting', 'admin', 'activity'));
    }

    public function updateGeneral(Request $request)
    {
        $data = $request->validate([
            'school_name'       => 'required|string|max:255',
            'timezone'          => 'required|string',
            'speaker_name'      => 'required|string|max:255',
            'speaker_connected' => 'boolean',
            'weekly_auto_repeat'=> 'boolean',
            'holiday_mode'      => 'boolean',
        ]);

        $data['speaker_connected']  = $request->boolean('speaker_connected');
        $data['weekly_auto_repeat'] = $request->boolean('weekly_auto_repeat');
        $data['holiday_mode']       = $request->boolean('holiday_mode');

        Setting::instance()->update($data);
        return redirect()->route('settings')->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'role'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => 'required',
                'new_password'     => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }

            $data['password'] = Hash::make($request->new_password);
        }

        unset($data['avatar']);
        $user->update($data);

        return redirect()->route('settings')->with('success', 'Profil berhasil diperbarui.');
    }
}
