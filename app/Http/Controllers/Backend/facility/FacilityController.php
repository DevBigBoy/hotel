<?php

namespace App\Http\Controllers\Backend\facility;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Facility $facility)
    {
        return view('backend.facility.index')->with(['facilities' => $facility::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.facility.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Facility $facility)
    {
        $validated  = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:facilities,name'],
        ]);

        $facility::create(
            [
                'name' => $validated['name']
            ]
        );

        $notification = [
            'message' => 'Facility Created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.facilities.index')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        return view('backend.facility.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255|unique:facilities,name,' . $facility->id,
            ]
        );

        $facility->update([
            'name' => $validated['name']
        ]);


        $notification = [
            'message' => 'Facility Updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.facilities.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();

        $notification = [
            'message' => 'Deleted successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.facilities.index')->with($notification);
    }
}