<?php

namespace App\Http\Controllers\Backend\Room;

use App\Models\Room;
use App\Models\Facility;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Room\RoomStoreRequest;
use App\Http\Requests\Backend\Room\RoomUpdateRequest;
use App\Traits\ImageUploadTrait;

class RoomController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with(['roomType', 'roomNumbers'])
            ->withAvailableRoomNumbersCount()
            ->get();
        return view('backend.room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $room_types = RoomType::get();
        return view('backend.room.create', compact('room_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomStoreRequest $request)
    {
        // Get all validated data except 'image'
        $validated = $request->validated();

        $data = collect($validated)->except('image')->toArray();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request, 'image', 'uploads/room_images');
        }

        Room::create($data);

        $notification = [
            'message' => 'Room Created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.rooms.index')->with($notification);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room_types = RoomType::get();

        $room = Room::with('images')->findOrFail($id);

        $facilities = Facility::all();

        return view('backend.room.edit', [
            'room' => $room,
            'room_types' => $room_types,
            'facilities' => $facilities
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomUpdateRequest $request, Room $room)
    {

        $validated = $request->validated();

        $data = collect($validated)->except('image')->toArray();

        if ($request->hasFile('image')) {
            $data['image'] = $this->UpdateImage($request, 'image', $room->image, 'uploads/room_images');
        }

        $room->update($data);

        // Sync facilities with the room
        if ($request->has('facilities')) {
            $room->facilities()->sync($request->facilities);
        } else {
            // If no facilities are selected, remove all facilities associated with the room
            $room->facilities()->sync([]);
        }

        $notification = [
            'message' => 'Room Updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.rooms.edit', $room->id)->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        $notification = [
            'message' => 'Room Deleted successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.rooms.index')->with($notification);
    }
}
