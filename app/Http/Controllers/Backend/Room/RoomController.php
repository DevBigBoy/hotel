<?php

namespace App\Http\Controllers\Backend\Room;

use App\Models\Room;
use App\Models\Facility;
use App\Models\RoomType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Room\RoomStoreRequest;
use App\Http\Requests\Backend\Room\RoomUpdateRequest;
use App\Traits\FileControlTrait;

class RoomController extends Controller
{
    use FileControlTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::select([
            'rooms.id',
            'rooms.total_adults',
            'rooms.total_children',
            'rooms.capacity',
            'rooms.image',
            'rooms.price_per_night',
            'rooms.discount',
            'rooms.status'
        ])
            ->withCount([
                'roomNumbers as room_numbers_count',  // Count all room numbers
                'roomNumbers as available_room_numbers_count' => function ($query) {
                    $query->where('status', 'available');  // Count only available rooms
                }
            ])
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->addSelect('room_types.name as room_type_name')  // Add room type name
            ->get();

        return view('backend.room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $room_types = RoomType::select(['id', 'name'])->get();
        return view('backend.room.create', compact('room_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomStoreRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadFile($request->file('image'), 'rooms');
        }

        Room::create($validated);

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
        $room_types = RoomType::select(['id', 'name'])->get();
        $facilities = Facility::select(['id', 'name'])->get();

        $room = Room::with([
            'images' => function ($query) {
                $query->select('id', 'room_id', 'image_path');
            },
            'facilities'
        ])->findOrFail($id);

        // Collect the Ids of the room's crrent facilities to mark as checked
        $selectedFacilities = $room->facilities->pluck('id')->toArray();

        // Pass all required data to the view
        return view('backend.room.edit', [
            'room' => $room,
            'room_types' => $room_types,
            'facilities' => $facilities,
            'selectedFacilities' => $selectedFacilities  // Pass selected facilities
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomUpdateRequest $request, Room $room)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteFile($room->image);
            $validated['image'] = $this->uploadFile($request->file('image'), 'rooms');
        }

        $room->update($validated);

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
