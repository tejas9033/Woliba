<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\WellbeingPillar;
use App\Models\WellnessInterest;
use App\Traits\Api\UniformResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WellnessController extends Controller
{
    use UniformResponseTrait;

    public function getInterests()
    {
        $interests = WellnessInterest::where('status', Status::ACTIVE->value)->orderBy('name')->get(['id', 'name']);

        return $this->sendResponse(!empty($interests), 'Wellness interests retrieved successfully.', $interests);
    }

    public function storeInterests(Request $request)
    {
        $rules = [
            'interests' => ['required', 'array', 'min:1']
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = $validator->errors()->all(':message');

            return $this->sendResponse(FALSE, $error[0]);
        }

        $ids = $validator->validated()['interests'];

        $request->user()->wellnessInterests()->sync($ids);

        return $this->sendResponse(TRUE, 'Interests saved successfully.');
    }

    public function getPillars()
    {
        $pillars = WellbeingPillar::where('status', Status::ACTIVE->value)->orderBy('name')->get(['id', 'name']);

        return $this->sendResponse(!empty($pillars), 'Wellness pillars retrieved successfully.', $pillars);
    }

    public function storePillars(Request $request)
    {
        $rules = [
            'pillars' => ['required', 'array', 'min:1'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = $validator->errors()->all(':message');

            return $this->sendResponse(FALSE, $error[0]);
        }

        $ids = $validator->validated()['pillars'];

        $request->user()->wellbeingPillars()->sync($ids);

        return $this->sendResponse(TRUE, 'Data saved successfully.');
    }
}
