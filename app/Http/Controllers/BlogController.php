<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->whereNotNull('user_id')
            ->latest()
            ->paginate(10);
    
        return view('blog.index', compact('posts'));
    }
    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('blog.show', compact('post'));
    }
    public function create()
    {
        return view('blog.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ];

        Post::create($data);

        return redirect()->route('blog.index')
            ->with('success', 'Post created successfully.');

    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (!$this->authorizeUser($post)) {
            return redirect()->route('blog.index')
                ->with('error', 'You do not have permission to edit this post.');
        }

        return view('blog.edit', compact('post'));
    }
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (!$this->authorizeUser($post)) {
            return redirect()->route('blog.index')
                ->with('error', 'You do not have permission to update this post.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        $post->update($data);

        return redirect()->route('blog.show', $post->id)
            ->with('success', 'Post updated successfully.');
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (!$this->authorizeUser($post)) {
            return redirect()->route('blog.index')
                ->with('error', 'You do not have permission to delete this post.');
        }

        $post->delete();

        return redirect()->route('blog.index')
            ->with('success', 'Post deleted successfully.');
    }

    private function authorizeUser($post)
    {
        $user = Auth::user();
        return $user && ($user->id === $post->user_id || $user->role === 'admin');
    }
}
