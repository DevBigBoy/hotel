<?php

namespace App\Http\Controllers\Backend\BookArea;

use App\Models\BookArea;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Backend\BookArea\BookAreaStoreRequest;
use App\Http\Requests\Backend\BookArea\BookAreaUpdateRequest;

class BookAreaController extends Controller
{

    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookareas = BookArea::get();
        return view('backend.book-area.index', compact('bookareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.book-area.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookAreaStoreRequest $request, BookArea $bookArea)
    {
        $data = $request->only([
            'title',
            'short_title',
            'description',
            'link',
            'status',
        ]);

        $imagePath = $this->uploadImage($request, 'image', 'uploads/bookarea');

        if ($imagePath) {
            $data['image'] = $imagePath;
        }

        $bookArea::create($data);

        $notification = [
            'message' => 'Book Area Inserted successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.bookarea.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookArea $bookarea)
    {
        return view('backend.book-area.show', compact('bookarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookArea $bookarea)
    {
        return view('backend.book-area.edit', compact('bookarea'));
    }

    /**id
     * Update the specified resource in storage.
     */
    public function update(BookAreaUpdateRequest $request, BookArea $bookarea)
    {
        $data = $request->only([
            'title',
            'short_title',
            'description',
            'link',
            'status',
        ]);

        $imagePath = $this->UpdateImage($request, 'image', $bookarea->image, 'uploads/bookarea');

        if ($imagePath) {
            $data['image'] =  $imagePath;
        }

        $bookarea->update($data);

        $notification = [
            'message' => 'Updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.bookarea.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookArea $bookarea)
    {
        if ($bookarea->image) {
            Storage::disk('public')->delete($bookarea->image);
        }

        $bookarea->delete();

        $notification = [
            'message' => ' Deleted successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.bookarea.index')->with($notification);
    }
}
