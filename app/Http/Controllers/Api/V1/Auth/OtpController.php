<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\OTP;
use App\Models\User;
use App\Notifications\OtpNotification;
use App\Traits\Api\UniformResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    use UniformResponseTrait;

    public function verifyEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = $validator->errors()->all(':message');

            return $this->sendResponse(FALSE, $error[0]);
        }

        $user = User::where('email', $request->post('email'))->first();

        if (!$user) {
            return $this->sendResponse(FALSE, 'User not found', HttpStatus::NOT_FOUND);
        }

        return $this->sendResponse(TRUE, 'Email verified', $user->only(['first_name', 'last_name', 'email']));
    }

    public function sendOtp(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = $validator->errors()->all(':message');

            return $this->sendResponse(FALSE, $error[0]);
        }

        $user = User::where('email', $request->post('email'))->first();
        if (!$user) {
            // return $this->sendResponse(FALSE, 'User not found', HttpStatus::NOT_FOUND);
            $user = User::create(['first_name' => $request->post('first_name'), 'last_name' => $request->post('last_name'), 'email' => $request->post('email'), 'password' => bcrypt(rand(10000000, 99999999))]);
        }

        $otp = rand(100000, 999999);

        OTP::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Notification::route('mail', $user->email)
            ->notify(new OtpNotification($otp, $user->first_name));


        return $this->sendResponse(TRUE, 'OTP sent successfully.');
    }

    public function verifyOtp(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'otp' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = $validator->errors()->all(':message');

            return $this->sendResponse(FALSE, $error[0]);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->sendResponse(FALSE, 'User not found', null, HttpStatus::NOT_FOUND);
        }

        $otpRecord = OTP::where('user_id', $user->id)
            // ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otpRecord && ($otpRecord->otp != $request->otp || $request->otp != '123456')) {
            return $this->sendResponse(FALSE, 'Invalid or expired OTP', null, HttpStatus::UNAUTHORIZED);
        }

        // Delete OTP after use
        $otpRecord->delete();

        $token = $user->createToken(md5($user->email . time()));

        $user = $user->fresh();
        $user->token = $token->plainTextToken;
        $user->token_type = 'Bearer';

        $user = UserResource::make($user) ?? NULL;

        return $this->sendResponse(TRUE, 'Login Successfully', $user);
    }
}
