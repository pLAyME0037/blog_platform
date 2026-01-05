<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        // Toggle the relationship
        Auth::user()->likes()->toggle($post->id);

        return back(); // Simple reload for Blade
    }
}