<?php

namespace App\Http\Controllers\Backend\Post;

use App\Models\Post;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Backend\post\PostStoreRequest;
use App\Http\Requests\Backend\post\PostUpdateRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category:id,name', 'author:id,name')->paginate(10);
        return view('backend.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories  = BlogCategory::get();
        return view('backend.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $post = $request->validated();

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->hashName('posts');
            // Resize and optimize image using Intervention Image version 3
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($image);
            $image->resize(550, 370)->save(storage_path('app/public/uploads/' . $imagePath), 80);  // Save with 80% quality
        }

        // Create the post with the uploaded image

        Post::create([
            'title' => $post['title'],
            'body' => $post['body'],
            'category_id' => $post['category_id'],
            'author_id' => auth()->id(),
            'status' => $post['status'],
            'image' => $imagePath,
        ]);


        $notification = [
            'message' => 'Post Created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.posts.index')->with($notification);
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
    public function update(PostUpdateRequest $request, string $id)
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
}
