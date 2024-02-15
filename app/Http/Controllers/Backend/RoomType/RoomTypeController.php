<?php

namespace App\Http\Controllers\Backend\RoomType;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoomType $roomType)
    {
        $types =  $roomType::latest()->get();
        return view('backend.room-type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.room-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, RoomType $roomType)
    {
        $validated   = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,archived']
        ]);

        $roomType::create($validated);

        $notification = [
            'message' => 'Room Type Created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.room-types.index')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomType $roomType)
    {
        return view('backend.room-type.edit', compact('roomType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomType $roomType)
    {
        $validated   = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,archived']
        ]);

        $roomType->update($validated);

        $notification = [
            'message' => 'Updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.room-types.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $roomType)
    {
        $roomType->delete();

        $notification = [
            'message' => 'Deleted successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.room-types.index')->with($notification);
    }
}