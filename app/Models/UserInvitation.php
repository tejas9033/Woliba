<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvitation extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'magic_token',
        'magic_token_expires_at',
        'magic_token_used_at',
        'otp_hash',
        'otp_expires_at',
        'status',
    ];

    protected $casts = [
        'magic_token_expires_at' => 'datetime',
        'magic_token_used_at' => 'datetime',
        'otp_expires_at' => 'datetime',
    ];

    public function toLimitedArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
        ];
    }
}
