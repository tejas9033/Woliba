<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\Status;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Models\UserInvitation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    public function loginWithToken(Request $request)
    {
        $rules = [
            'token' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = $validator->errors()->all(':message');

            return $this->sendResponse(FALSE, $error[0]);
        }

        $token = (string) $request->query('token');

        $userInvitation = UserInvitation::where('magic_token', $token)->first();

        if (!$userInvitation || !$userInvitation->magic_token_expires_at || $userInvitation->magic_token_expires_at->isPast() || $userInvitation->magic_token_used_at) {
            return $this->sendResponse(FALSE, 'Invalid or expired link. Please request a new link.');
        }

        $userInvitation->update(['magic_token_used_at' => now(), 'status' => Status::ACTIVE->value]);

        $name = trim($userInvitation->first_name . ' ' . ($userInvitation->last_name ?? ''));
        $user = User::firstOrCreate(
            ['email' => $userInvitation->email],
            ['name' => $name ?: null, 'password' => bcrypt(str()->random(16))]
        );

        // $user->tokens()->delete();
        $token = $user->createToken(md5($user->email . time()));

        $user = $user->fresh();
        $user->token = $token->plainTextToken;
        $user->token_type = 'Bearer';

        $user = UserResource::make($user) ?? NULL;

        return $this->sendResponse(TRUE, 'Login Successfully', $user);
    }

    public function logout()
    {
        if (!empty(auth('sanctum')->user()) && !empty(auth('sanctum')->user()->tokens())) {
            auth('sanctum')->user()->tokens()->delete();
        }

        return $this->sendResponse(TRUE, __('api/auth.logout.success'));
    }
}
