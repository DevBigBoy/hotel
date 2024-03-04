<?php

namespace App\Http\Controllers\Backend\Room;

use App\Models\Room;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\FileControlTrait;
use Illuminate\Support\Facades\Storage;

class MultiImageController extends Controller
{
    use FileControlTrait;

    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'multi_img' => ['required', 'array'],
            'multi_img.*' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);


        foreach ($request->file('multi_img') as $image) {
            $image_path = $this->uploadFile($image, 'rooms');
            $room->images()->create(['image_path' => $image_path]);
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
