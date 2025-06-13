<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
     // ----------- AUTHENTICATION ------------
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            $user = User::create([
                'id' => Str::uuid(),
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $user->assignRole('user');

            return response()->json([
                'token' => $user->createToken('api-token')->plainTextToken,
                'user' => $user
            ]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages(['email' => ['Invalid credentials.']]);
            }

            return response()->json([
                'token' => $user->createToken('api-token')->plainTextToken,
                'user' => $user,
            ]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    // ----------- POST ------------
    public function getPosts()
    {
        try {
            return Post::with(['user', 'tags', 'comments'])->latest()->get();
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createPost(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                'tags' => 'array',
                'tags.*' => 'string',
            ]);

            $post = Post::create([
                'id' => Str::uuid(),
                'user_id' => Auth::id(),
                'title' => $data['title'],
                'content' => $data['content'],
            ]);

            if (!empty($data['tags'])) {
                $tagIds = collect($data['tags'])->map(function ($tagName) {
                    return Tag::firstOrCreate(['name' => Str::slug($tagName)])->id;
                });

                $post->tags()->sync($tagIds);
            }

            return response()->json($post->load('tags'));
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePost(Request $request, Post $post)
    {
        try {
            if (Auth::id() !== $post->user_id && !Auth::user()->hasRole('admin')) {
                abort(403);
            }

            $data = $request->validate([
                'title' => 'sometimes|string',
                'content' => 'sometimes|string',
            ]);

            $post->update($data);

            return response()->json($post);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deletePost(Post $post)
    {
        try {
            if (Auth::id() !== $post->user_id && !Auth::user()->hasRole('admin')) {
                abort(403);
            }

            $post->delete();

            return response()->json(['message' => 'Post deleted.']);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ----------- COMMENT ------------
    public function getComments(Post $post)
    {
        try {
            return $post->comments()->with('user')->get();
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createComment(Request $request, Post $post)
    {
        try {
            $data = $request->validate([
                'content' => 'required|string',
            ]);

            $comment = $post->comments()->create([
                'id' => Str::uuid(),
                'user_id' => Auth::id(),
                'content' => $data['content'],
            ]);

            return response()->json($comment);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteComment(Comment $comment)
    {
        try {
            if (Auth::id() !== $comment->user_id && !Auth::user()->hasRole('admin')) {
                abort(403);
            }

            $comment->delete();

            return response()->json(['message' => 'Comment deleted.']);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ----------- TAG ------------
    public function getTags()
    {
        try {
            return Tag::all();
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createTag(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|unique:tags,name',
            ]);

            $tag = Tag::create([
                'name' => Str::slug($data['name']),
            ]);

            return response()->json($tag);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteTag(Tag $tag)
    {
        try {
            if (!Auth::user()->hasRole('admin')) {
                abort(403);
            }

            $tag->delete();

            return response()->json(['message' => 'Tag deleted.']);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ----------- LIKE / UNLIKE ------------
    public function likePost(Post $post)
    {
        try {
            $post->likes()->syncWithoutDetaching([Auth::id()]);
            return response()->json(['liked' => true]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function unlikePost(Post $post)
    {
        try {
            $post->likes()->detach(Auth::id());
            return response()->json(['liked' => false]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
