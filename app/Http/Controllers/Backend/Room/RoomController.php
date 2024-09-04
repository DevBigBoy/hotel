<?php

namespace App\Http\Controllers\Backend\Room;

use App\Models\Room;
use App\Models\Facility;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::get();
        return view('backend.room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $room_types = RoomType::get();
        $facilities = Facility::all();
        return view('backend.room.create', compact('room_types', 'facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function uploadImages(Request $request)
    {
        // Validate the incoming files
        $validator = Validator::make($request->all(), [
            'files.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        $files = $request->file('files');

        $uploadedFiles = [];

        if ($files) {
            foreach ($files as $file) {
                // Store the image in the public directory
                $path = $file->store('uploads/room_images', [
                    'disk' => 'public'
                ]);

                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                ];
            }
        }

        return response()->json(['files' => $uploadedFiles]);
    }
}
