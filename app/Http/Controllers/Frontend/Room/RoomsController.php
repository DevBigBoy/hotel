<?php

namespace App\Http\Controllers\Frontend\Room;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomsController extends Controller
{
    public function index()
    {
        $rooms = Room::select([
            'id',
            'room_type_id',
            'image',
            'price_per_night',
            'status',
        ])
            ->with(['roomType:id,name'])
            ->withCount(['roomNumbers' => function ($query) {
                $query->where('status', 'available');
            }])
            ->where('status', 'available')
            ->whereHas('roomNumbers', function ($query) {
                $query->where('status', 'available');
            })
            ->get();

        // return response()->json($rooms);

        return view('frontend.pages.rooms.index', [
            'rooms' => $rooms
        ]);
    }

    public function show(Request $request, string $roomId)
    {
        $request->flash();

        // First, check if the room exists with the required data
        $room = Room::select([
            'id',
            'room_type_id',
            'total_adults',
            'total_children',
            'capacity',
            'image',
            'price_per_night',
            'discount',
            'bed_type',
            'view_type',
            'room_size',
            'short_desc',
            'description',
            'status',
        ])
            // Eager load related data only if necessary
            ->with([
                'roomType:id,name',
                'images:id,image_path,room_id', // Include room_id in images for relationship
                'facilities:id,name',
            ])
            // Count available room numbers
            ->withCount(['roomNumbers as available_room_numbers_count' => function ($query) {
                $query->where('status', 'available');
            }])
            ->where('id', $roomId)
            ->first();

        // If the room is not available, return with an error
        if (!$room || $room->available_room_numbers_count <= 0) {
            $notification = [
                'message' => 'No rooms available',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }


        // Fetch other rooms excluding the current room and limit to 2
        $other_rooms = Room::select([
            'id',
            'room_type_id',
            'capacity',
            'image',
            'price_per_night',
            'discount',
            'bed_type',
            'view_type',
            'room_size',
            'short_desc',
            'status',
        ])
            ->with([
                'roomType:id,name',
            ])
            ->withCount(['roomNumbers as available_room_numbers_count' => function ($query) {
                $query->where('status', 'available');
            }])
            ->where('id', '!=', $room->id)
            ->where('status', 'available')
            ->having('available_room_numbers_count', '>', 0)
            ->orderBy('id', 'DESC')
            ->limit(2)
            ->get();

        // Return the view with the room and other available rooms
        return view('frontend.pages.rooms.show', compact('room', 'other_rooms'));
    }





    public function CheckRoomAvailability(Request $request) {}
}
