<?php
namespace App\Http\Controllers;

use App\Models\Post;

class PublicPostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'images'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        // Load comments and likes for later steps
        $post->load(['user', 'images', 'comments.user']);

        return view('posts.show', compact('post'));
    }
}
