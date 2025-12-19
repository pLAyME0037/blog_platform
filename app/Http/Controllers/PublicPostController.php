<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    /**
     * Display the landing page with a grid of posts.
     */
    public function index()
    {
        // 1. Get posts
        // 2. 'with' loads the author name efficiently
        // 3. 'latest' orders by created_at desc
        // 4. 'paginate' handles page numbers automatically
        $posts = Post::with('user')->latest()->paginate(9);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display a single full post.
     */
    public function show(Post $post)
    {
        // Optional: Load comments and user relationships if needed here, 
        // though Blade can handle lazy loading for single pages fine.
        return view('posts.show', compact('post'));
    }
}