<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileControlTrait
{
    /**
     * Handle the upload of a file.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string|null
     */
    public function uploadFile(UploadedFile $uploadedFile, string $directory): ?string
    {
        if ($uploadedFile) {
            $path = $uploadedFile->store("uploads/" . $directory, [
                'disk' => 'public'
            ]);
            return $path;
        }

        return null;
    }

    /**
     * Delete a file if it exists.
     *
     * @param string|null $filePath
     * @return void
     */

    public function deleteFile(?string $filePath): void
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}