<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // 1. Validate
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // 2. Create Comment
        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // 3. Redirect back to the post
        return back()->with('success', 'Comment posted!');
    }

    public function destroy(Comment $comment)
    {
        // Security: Only delete if I own the comment OR I own the post
        if (Auth::id() !== $comment->user_id && Auth::id() !== $comment->post->user_id) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted!');
    }
}