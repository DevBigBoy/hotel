<?php

namespace App\Http\Controllers\Frontend\Room;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomsController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['roomType', 'roomNumbers'])
            ->get();
        return view('frontend.pages.rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        try {
            // Eager load the roomType and roomNumbers relationships
            $room->load(['roomType', 'roomNumbers', 'images', 'facilities']);

            // Return the view with the room data
            return view('frontend.pages.rooms.show', compact('room'));
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            dd('error', 'Room not found or could not be loaded.');
        }
    }
}
