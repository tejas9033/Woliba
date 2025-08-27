<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWellnessInterest extends Model
{
    protected $fillable = [
        'user_id',
        'wellness_interest_id',
    ];
}
