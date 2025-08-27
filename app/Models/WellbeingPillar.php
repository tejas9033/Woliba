<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WellbeingPillar extends Model
{
    protected $table = 'wellbeing_pillars';

    protected $fillable = [
        'name',
        'status',
    ];
}
