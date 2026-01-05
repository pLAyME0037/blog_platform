<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
// Important for Policies

class DashboardPostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Fetch ONLY my posts, eager load images for performance
        $posts = Auth::user()->posts()->with('images')->latest()->paginate(10);
        return view('dashboard.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
        ]);

        // 2. Create Post
        $post = Auth::user()->posts()->create([
            'title'        => $request->title,
            'slug'         => Str::slug($request->title) . '-' . Str::random(4), // Unique Slug
            'content'      => $request->content,
            'published_at' => now(),
        ]);

        // 3. Handle Multiple Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('posts', 'public'); // Store in storage/app/public/posts
                $post->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('dashboard.posts.index')->with('success', 'Post created!');
    }

    // Show the Edit Form
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('dashboard.posts.edit', compact('post'));
    }

    // Handle the Update Logic
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update basic fields
        $post->update([
            'title'   => $request->title,
            'slug'    => Str::slug($request->title) . '-' . $post->id, // Update slug too
            'content' => $request->content,
        ]);

        // Add NEW images (keep old ones)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('posts', 'public');
                $post->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('dashboard.posts.index')->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        // Check Policy: Only owner can delete
        $this->authorize('delete', $post);

        $post->delete();

        return back()->with('success', 'Post deleted!');
    }
}
