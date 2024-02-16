<?php

namespace App\Http\Controllers\Backend\Room;

use App\Models\Room;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MultiImageController extends Controller
{
    use ImageUploadTrait;
    public function store(Request $request, Room $room)
    {

        $validated = $request->validate([
            'multi_img' => ['required', 'array'],
            'multi_img.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $image_paths = $this->uploadMultiImages($request, 'multi_img', 'uploads/room_images');


        if ($image_paths) {
            foreach ($image_paths as $path) {
                MultiImage::create([
                    'room_id' => $room->id,
                    'image_path' => $path,
                    'is_main' => false
                ]);
            }
        }

        $notification = [
            'message' => 'Images Created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.rooms.edit', $room->id)->with($notification);
    }

    public function destroy(Room $room, MultiImage $multiImage)
    {
        Storage::disk('public')->delete($multiImage->image_path);

        // Delete the image record from the database
        $multiImage->delete();

        $notification = [
            'message' => 'Images Created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.rooms.edit', $room->id)->with($notification);
    }
}
