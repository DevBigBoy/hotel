<?php

namespace App\Http\Controllers\Backend\RoomNumber;

use App\Models\Room;
use App\Models\RoomNumber;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\RoomNumber\RoomNumberStoreRequest;
use App\Http\Requests\Backend\RoomNumber\RoomNumberUpdateRequest;

class RoomNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::exists();

        $room_numbers = RoomNumber::with(
            [
                'room' => function ($query) {
                    $query->select('id', 'room_type_id', 'total_adults', 'total_children');  // Only fetch necessary room columns
                },
                'room.roomType' => function ($query) {
                    $query->select('id', 'name');  // Only fetch necessary room type columns
                }
            ]
        )->orderBy('room_id')->get();

        return view('backend.room-number.index', compact('room_numbers', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::with('roomType:id,name')->get();
        return view('backend.room-number.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomNumberStoreRequest $request)
    {
        $data = $request->validated();

        RoomNumber::create($data);

        $notification = [
            'message' => 'Room Number Created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.room-numbers.create')->with($notification);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomNumber $roomNumber)
    {
        $rooms = Room::with('roomType:id,name')->get();
        return view('backend.room-number.edit', compact('rooms', 'roomNumber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomNumberUpdateRequest $request, RoomNumber $roomNumber)
    {
        $data = $request->validated();

        $roomNumber->update($data);

        $notification = [
            'message' => 'Room Number Updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.room-numbers.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomNumber $roomNumber)
    {
        $roomNumber->delete();

        $notification = [
            'message' => "{$roomNumber->room_number} Deleted successfully!",
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.room-numbers.index')->with($notification);
    }
}
