<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BellPeriod extends Model
{
    protected $fillable = ['name', 'time', 'sound', 'status', 'sort_order'];
}
