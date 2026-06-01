<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioTrack extends Model
{
    protected $fillable = ['file_name', 'file_path', 'duration'];
}
