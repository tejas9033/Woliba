<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Api\UniformResponseTrait;
use App\Traits\Common\UploadFileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    use UploadFileTrait;
    use UniformResponseTrait;

    protected int $pagination = 10;

    public function __construct()
    {
        Validator::extend('custom_unique', function ($attribute, $value, $content) {
            $table = $content[0] ?? NULL;
            $primaryId = $content[1] ?? NULL;

            $hasMatched = DB::table($table)->where($attribute, $value);
            if (!empty($primaryId)) {
                $hasMatched = $hasMatched->where('id', '!=', $primaryId);
            }
            $hasMatched = $hasMatched->whereNull('deleted_at')->count();

            return $hasMatched == 0;
        });
    }
}
