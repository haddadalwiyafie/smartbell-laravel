<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'school_name', 'timezone', 'speaker_name',
        'speaker_connected', 'weekly_auto_repeat', 'holiday_mode',
    ];

    protected $casts = [
        'speaker_connected'   => 'boolean',
        'weekly_auto_repeat'  => 'boolean',
        'holiday_mode'        => 'boolean',
    ];

    public static function instance(): self
    {
        return self::firstOrCreate([], [
            'school_name'        => 'SDIT AL-FATIH',
            'timezone'           => 'Eastern Time (ET)',
            'speaker_name'       => 'School Wide Audio System',
            'speaker_connected'  => true,
            'weekly_auto_repeat' => true,
            'holiday_mode'       => false,
        ]);
    }
}
