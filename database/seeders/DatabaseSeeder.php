<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\AudioTrack;
use App\Models\BellPeriod;
use App\Models\BellSchedule;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Principal Skinner',
            'role'     => 'System Administrator',
            'email'    => 'admin@smartbell.com',
            'phone'    => '(555) 123-4567',
            'password' => Hash::make('password'),
        ]);

        Setting::create([
            'school_name'        => 'SDIT AL-FATIH',
            'timezone'           => 'Eastern Time (ET)',
            'speaker_name'       => 'School Wide Audio System',
            'speaker_connected'  => true,
            'weekly_auto_repeat' => true,
            'holiday_mode'       => false,
        ]);

        $periods = [
            ['name' => 'Period 1',   'time' => '08:00:00', 'sound' => 'Morning Chime',   'status' => 'Played',  'sort_order' => 1],
            ['name' => 'Period 2',   'time' => '09:00:00', 'sound' => 'Single Bell',     'status' => 'Played',  'sort_order' => 2],
            ['name' => 'Period 3',   'time' => '10:00:00', 'sound' => 'Double Bell',     'status' => 'Played',  'sort_order' => 3],
            ['name' => 'Period 4',   'time' => '11:15:00', 'sound' => 'Long Tone',       'status' => 'Next',    'sort_order' => 4],
            ['name' => 'Lunch',      'time' => '12:15:00', 'sound' => 'Soft Melody',     'status' => 'Pending', 'sort_order' => 5],
            ['name' => 'Period 5',   'time' => '13:15:00', 'sound' => 'Single Bell',     'status' => 'Pending', 'sort_order' => 6],
            ['name' => 'Period 6',   'time' => '14:15:00', 'sound' => 'Double Bell',     'status' => 'Pending', 'sort_order' => 7],
            ['name' => 'Dismissal',  'time' => '15:15:00', 'sound' => 'End-of-Day Tune', 'status' => 'Pending', 'sort_order' => 8],
        ];
        foreach ($periods as $p) {
            BellPeriod::create($p);
        }

        $schedules = [
            ['title' => 'Morning Start',          'time' => '08:00:00', 'meridiem' => 'AM', 'days' => ['Mon','Tue','Wed','Thu','Fri'], 'audio_file' => 'Standard Chime 1.mp3', 'status' => 'Active'],
            ['title' => 'Period 1 End',            'time' => '09:45:00', 'meridiem' => 'AM', 'days' => ['Mon','Tue','Wed','Thu','Fri'], 'audio_file' => 'Short Ring.mp3',       'status' => 'Active'],
            ['title' => 'Lunch Start (Assembly Day)', 'time' => '12:15:00', 'meridiem' => 'PM', 'days' => ['Wed'],                    'audio_file' => 'Upbeat Tone.mp3',      'status' => 'Inactive'],
        ];
        foreach ($schedules as $s) {
            BellSchedule::create($s);
        }

        AudioTrack::insert([
            ['file_name' => 'Morning_Bell_Upbeat.mp3',    'file_path' => 'audio/Morning_Bell_Upbeat.mp3',    'duration' => '0:15', 'created_at' => now(), 'updated_at' => now()],
            ['file_name' => 'Emergency_Evac_Standard.mp3','file_path' => 'audio/Emergency_Evac_Standard.mp3','duration' => '0:45', 'created_at' => now(), 'updated_at' => now()],
            ['file_name' => 'Lunch_Period_Start.mp3',     'file_path' => 'audio/Lunch_Period_Start.mp3',     'duration' => '0:10', 'created_at' => now(), 'updated_at' => now()],
        ]);

        ActivityLog::insert([
            ['kind' => 'auto',   'description' => 'Period 3 Bell triggered automatically.',   'created_at' => now()->subMinutes(45), 'updated_at' => now()->subMinutes(45)],
            ['kind' => 'manual', 'description' => 'Manual Announcement by Administrator.',    'created_at' => now()->subMinutes(78), 'updated_at' => now()->subMinutes(78)],
            ['kind' => 'auto',   'description' => 'Period 2 Bell triggered automatically.',   'created_at' => now()->subHours(2),    'updated_at' => now()->subHours(2)],
        ]);
    }
}
