<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog_categories = BlogCategory::latest()->get();
        return view('backend.blog-category.index', compact('blog_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated =  $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:blog_categories,name']
        ]);

        BlogCategory::create([
            'name' => $validated['name']
        ]);

        $notification = [
            'message' => 'Category Created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.blog_categories.index')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blog_category)
    {
        return response()->json($blog_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blog_category)
    {
        $validated =  $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:blog_categories,name,' . $blog_category->id]
        ]);

        $blog_category->update([
            'name' => $validated['name']
        ]);

        $notification = [
            'message' => 'Category Updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.blog_categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blog_category)
    {
        $blog_category->delete();

        $notification = [
            'message' => 'Category Deleted successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.blog_categories.index')->with($notification);
    }
}