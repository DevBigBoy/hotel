<?php

namespace App\Http\Controllers\Frontend\Room;

use App\Models\Room;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Request;

class RoomsController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['roomType:id,name'])
            ->select([
                'id',
                'room_type_id',
                'image',
                'price_per_night',
            ])
            ->where('status', 'available')
            ->has('roomNumbers')
            ->get();

        return view('frontend.pages.rooms.index', [
            'rooms' => $rooms
        ]);
    }

    public function show(string $roomId)
    {
        // First, check if the room exists with minimal data to avoid unnecessary loading
        $roomExists = Room::where('id', $roomId)
            ->where('status', 'available')
            ->has('roomNumbers')
            ->exists();


        // If the room doesn't exist, throw 404 early without loading unnecessary data
        if (!$roomExists) {
            abort(404, 'The requested room does not exist, is unavailable, or cannot be booked.');
        }

        $room = Room::with(['roomType:id,name', 'images:id,image_path', 'facilities:id,name'])
            ->select([
                'room_type_id',
                'total_adults',
                'total_children',
                'capacity',
                'image',
                'price_per_night',
                'size',
                'view',
                'bed_style',
                'discount',
                'short_desc',
                'description',
            ])
            ->findOrFail($roomId);

        // Fetch other rooms excluding the current room and limit to 2
        $other_rooms = Room::where('id', '!=', $room->id)
            ->with(['roomType:id,name'])
            ->select(['id', 'room_type_id', 'image', 'short_desc', 'price_per_night', 'capacity', 'view', 'bed_style'])
            ->where('status', 'available')
            ->has('roomNumbers')
            ->orderBy('id', 'DESC')
            ->limit(2)
            ->get();

        // Return the view with the room and other rooms data
        return view('frontend.pages.rooms.show', [
            'room' => $room,
            'other_rooms' => $other_rooms
        ]);
    }
}
