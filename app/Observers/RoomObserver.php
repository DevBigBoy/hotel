<?php

namespace App\Observers;

use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class RoomObserver
{
    /**
     * Handle the Room "created" event.
     */
    public function created(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "updated" event.
     */
    public function updated(Room $room): void
    {
        //
    }

    public function deleting(Room $room)
    {
        // Delete related room numbers
        $room->roomNumbers()->delete();

        // Delete associated facilities in the pivot table
        $room->facilities()->detach();

        // Delete room images
        foreach ($room->images as $image) {
            // Remove the image file from storage
            Storage::disk('public')->delete($image->image_path);
        }
        // Delete the image records from the database
        $room->images()->delete();

        // Delete the main image file for the room if it exists
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }
    }

    /**
     * Handle the Room "deleted" event.
     */
    public function deleted(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "restored" event.
     */
    public function restored(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "force deleted" event.
     */
    public function forceDeleted(Room $room): void
    {
        //
    }
}