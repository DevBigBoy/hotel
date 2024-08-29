<?php

namespace App\Traits;

use Illuminate\Http\Request;


trait ImageUploadTrait
{
    public function uploadImage(Request $request, $inputName, $folder)
    {

        if (!$request->hasFile($inputName)) {
            return;
        }

        if ($request->hasFile($inputName)) {
            $file  = $request->file($inputName);

            $path = $file->store($folder, [
                'disk' => 'public'
            ]);

            return $path;
        }
    }
}