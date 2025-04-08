<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        return view('comments.index');
    }

    public function show()
    {
        return view('comments.show');
    }

    public function create()
    {
        return view('comments.create');
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        
        $post = Post::findOrFail($postId);

        $data = [
            'content' => $request->content,
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ];
        
        Comment::create($data);

        return redirect()->route('blog.show', $post->id)
            ->with('success', 'Comment added successfully.');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        if (!$this->authorizeUser($comment)) {
            return redirect()->route('blog.index')
                ->with('error', 'You do not have permission to edit this comment.');
        }

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if (!$this->authorizeUser($comment)) {
            return redirect()->route('blog.index')
                ->with('error', 'You do not have permission to update this comment.');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $data = [
            'content' => $request->content,
        ];

        $comment->update($data);

        return redirect()->route('blog.show', $comment->post_id)
            ->with('success', 'Comment updated successfully.');
    }

    public function destroy($postId, $id)
    {
        $comment = Comment::findOrFail($id);

        if (!$this->authorizeUser($comment)) {
            return redirect()->route('blog.show', $postId)
                ->with('error', 'You do not have permission to delete this comment.');
        }

        $comment->delete();

        return redirect()->route('blog.show', $postId)
            ->with('success', 'Comment deleted successfully.');
    }

    public function authorizeUser($comment)
    {
        $user = Auth::user();
        return $user && ($user->id === $comment->user_id || $user->role === 'admin');
    }
}
