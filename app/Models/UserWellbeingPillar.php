<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWellbeingPillar extends Model
{
    protected $fillable = [
        'user_id',
        'wellbeing_pillar_id',
    ];
}
