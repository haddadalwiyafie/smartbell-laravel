<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BellSchedule extends Model
{
    protected $fillable = ['title', 'time', 'meridiem', 'days', 'audio_file', 'status'];
    protected $casts = ['days' => 'array'];
}
