<?php

namespace App\Http\Controllers\Frontend\Post;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index(Request $request)
    {

        $search = $request->input('search');
        $categoryId = $request->input('category');  // Get the selected category ID

        // Fetch all categories for the filter dropdown
        $categories =  BlogCategory::select(['id', 'name'])->get();

        $recentPosts = Post::where('status', 'published')->latest()->limit(3)->get();
        // Fetch posts with optional search and category filters
        $posts = Post::where('status', 'published')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pages.posts.index', compact('posts', 'categories', 'recentPosts', 'categoryId', 'search'));
    }


    public function show($slug)
    {
        $categories = BlogCategory::select(['id', 'name'])->get();

        // Find the post by slug
        $post = Post::where('slug', $slug)->with('author:id,name')->firstOrFail();

        // Fetch related posts (same category, excluding the current post)
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->limit(3)
            ->get();


        return view('frontend.pages.posts.show', compact('categories', 'post', 'relatedPosts'));
    }
}
