<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends BaseController
{
    public function index(): JsonResponse
    {
        $user = User::find(auth('sanctum')->id());
        if (!empty($user)) {
            $user = UserResource::make($user);
        }

        return $this->sendResponse(TRUE, 'Profile fetched successfully', !empty($user) ? $user : []);
    }

    public function update(Request $request): JsonResponse
    {
        $userId = auth('sanctum')->id();

        $rules = [
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'dob' => 'nullable|date_format:Y-m-d',
            'mobile_number' => 'nullable|string|max:15|unique:users,mobile_number,' . $userId,
            'profile_picture' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|max:100|confirmed',
        ];

        $validator = Validator::make($request->post(), $rules);
        if ($validator->fails()) {
            $error = $validator->errors()->all(':message');

            return $this->sendResponse(FALSE, $error[0]);
        }

        $userData = $request->post();
        $user = User::find($userId);
        $user->fill($userData);

        if ($request->hasFile('profile_picture')) {
            $profileFile = $request->file('profile_picture');
            $extension = $profileFile->getClientOriginalExtension();
            $user->profile_picture = $this->verifyAndUpload($profileFile, $userId . '.' . $extension, 'users');
        }
        $user->save();

        if (!empty($user)) {
            $user = UserResource::make($user);
        }

        return $this->sendResponse(TRUE, 'Profile updated successfully.', !empty($user) ? $user : []);
    }
}
