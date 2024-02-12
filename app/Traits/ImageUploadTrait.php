<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function UpdateImage(Request $request, $inputName, $oldImage, $folder)
    {
        if (!$request->hasFile($inputName)) {
            return;
        }

        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);

            $path = $file->store($folder, [
                'disk' => 'public'
            ]);

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            return $path;
        }
    }
}
