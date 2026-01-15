<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardPostController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $posts = Auth::user()
            ->posts()
            ->latest()
            ->paginate(10);

        return view('dashboard.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:2',
            'content' => 'required',
        ]);

        Auth::user()->posts()->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'content' => $data['content'],
        ]);

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post created successfully!');
    }

    public function show(Post $post){
        $post->load(['user','comments','likes']);
        return view('dashboard.posts.show',compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update',$post);

        return view('dashboard.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:10',
        ]);

        $post->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'content' => $data['content'],
        ]);

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back()->with('success', 'Post deleted!');
    }
}
