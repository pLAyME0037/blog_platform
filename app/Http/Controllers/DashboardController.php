<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $posts = Post::with(['user','comments','likes'])->latest()->get();
        return view('dashboard',compact('posts'));
    }
}
