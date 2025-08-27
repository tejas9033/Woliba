<?php

namespace App\Traits\Common;

trait UploadFileTrait
{
    public function verifyAndUpload($file, $fileName, $directory): array|string
    {
        if (!$file->isValid()) {

            return ['error' => 'Invalid file!'];
        }

        $filePath = $file->storeAs($directory, $fileName);

        return 'storage/' . $filePath;
    }
}
