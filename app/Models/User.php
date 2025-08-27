<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'mobile_number',
        'email',
        'password',
        'profile_picture',
        'confirmation_flag',
        'registration_complete',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'profile_picture_url',
    ];

    public function getProfilePictureUrlAttribute(): ?string
    {
        if ($this->profile_picture) {
            return asset($this->profile_picture);
        }
        return null;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date',
            'confirmation_flag' => 'boolean',
            'registration_complete' => 'boolean',
        ];
    }

    public function wellnessInterests()
    {
        return $this->belongsToMany(WellnessInterest::class, 'user_wellness_interests');
    }

    public function wellbeingPillars()
    {
        return $this->belongsToMany(WellbeingPillar::class, 'user_wellbeing_pillars');
    }
}
