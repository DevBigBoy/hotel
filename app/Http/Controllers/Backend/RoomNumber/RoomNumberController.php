<?php

namespace App\Http\Controllers\Backend\RoomNumber;

use App\Models\Room;
use App\Models\RoomNumber;
use Illuminate\Http\Request;
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
        $rooms = Room::with(['roomType', 'roomNumbers'])->get();
        return view('backend.room-number.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::with('roomType')->get();
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
        $rooms = Room::with('roomType')->get();

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