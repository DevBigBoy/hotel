<?php

namespace App\Http\Controllers\Backend\Team;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Backend\Team\TeamStoreRequest;
use App\Http\Requests\Backend\Team\TeamUpdateRequest;

class TeamController extends Controller
{

    public function __construct(
        public Team $team
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = $this->team::latest()->get();
        return view('backend.team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamStoreRequest $request)
    {
        $new_team =  $request->except('image');


        if ($request->hasFile('image')) {
            // create image manager with desired driver
            $file = $request->file('image');

            $manager = new ImageManager(new Driver());

            $image_name = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();

            // read image from file system
            $image = $manager->read($file);

            // resize image proportionally to 300px width
            $image->resize(550, 670)->save(base_path('public/storage/uploads/teams/' . $image_name));

            $new_team['image'] = 'uploads/teams/' . $image_name;
        }


        $this->team::create($new_team);

        $notification = [
            'message' => 'Team Data Inserted successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.teams.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return view('backend.team.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('backend.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamUpdateRequest $request, Team $team)
    {
        $new_team =  $request->except('image');


        $imagePath = $this->imageUpload($request);

        if ($imagePath) {
            $new_team['image'] = $imagePath;
        }

        if ($team->image && $imagePath) {
            Storage::disk('public')->delete($team->image);
        }

        $team->update($new_team);

        $notification = [
            'message' => 'Team Data Updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.teams.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {

        if ($team->image) {
            Storage::disk('public')->delete($team->image);
        }

        $team->delete();

        $notification = [
            'message' => 'Team Data Deleted successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.teams.index')->with($notification);
    }

    public function imageUpload(Request $request)
    {

        if (!$request->hasFile('image')) {
            return;
        }

        if ($request->hasFile('image')) {
            // create image manager with desired driver
            $file = $request->file('image');

            $manager = new ImageManager(new Driver());

            $image_name = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();

            // read image from file system
            $image = $manager->read($file);

            // resize image proportionally to 300px width
            $image->resize(550, 670)->save(base_path('public/storage/uploads/teams/' . $image_name));

            $path = 'uploads/teams/' . $image_name;

            return $path;
        }
    }
}
