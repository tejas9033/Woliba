<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\Status;
use App\Http\Controllers\Api\BaseController;
use App\Models\UserInvitation;
use App\Notifications\MagicLinkNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class InviteController extends BaseController
{
    public function store(Request $request)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255'],
        ];

        $validator = Validator::make($request->post(), $rules);
        if ($validator->fails()) {
            $error = $validator->errors()->all(':message');

            return $this->sendResponse(FALSE, $error[0]);
        }

        $requestData = $validator->validated();
        $data = array_map('trim', $requestData);

        $invitation = UserInvitation::updateOrCreate(
            ['email' => $data['email']],
            [
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'] ?? null,
                'status'     => Status::INACTIVE->value,
                'magic_token' => Str::random(64),
                'magic_token_expires_at' => now()->addMinutes(60),
                'magic_token_used_at' => null,
                'otp_hash' => null,
                'otp_expires_at' => null,
            ]
        );

        $magicUrl = url('/api/v1/magic-link/user?token=' . $invitation->magic_token);

        Notification::route('mail', $invitation->email)
            ->notify(new MagicLinkNotification($magicUrl, $invitation->first_name));

        return $this->sendResponse(TRUE, 'Invitation created. If the email is valid, a magic link has been sent.');
    }
}
