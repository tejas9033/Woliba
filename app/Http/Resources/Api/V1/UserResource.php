<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'dob' => $this->dob,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'profile_picture' => $this->profile_picture_url ?? NULL,
            'token' => $this->token ?? NULL,
            'registerd_at' => $this->created_at->format('M d, Y')
        ];
    }
}
