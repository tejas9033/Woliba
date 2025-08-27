<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WellnessInterest extends Model
{
    protected $table = 'wellness_interests';

    protected $fillable = [
        'name',
        'status',
    ];
}
