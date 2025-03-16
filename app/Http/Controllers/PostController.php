<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Helpers\ResponseHelper;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PostController extends Controller
{
    // Create a new post
    public function store(PostRequest $request)
    {
        try {
            $post = Post::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => Auth::id()
            ]);

            $post->tags()->attach($request->tags);

            return ResponseHelper::success($post, 'Post created successfully', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to create post', 500);
        }
    }

    // List all posts with pagination
    public function index(Request $request)
    {
        try {
            $cacheKey = 'posts_' . $request->input('sort_by', 'published_at') . '_page_' . $request->input('page', 1);
    
            $posts = cache()->remember($cacheKey, now()->addMinutes(10), function () use ($request) {
                return Post::with(['category', 'tags', 'user'])
                    ->where('status', 'published')
                    ->orderBy($request->input('sort_by', 'published_at'), 'desc')
                    ->paginate(10);
            });
    
            return ResponseHelper::success($posts, 'Posts fetched successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to fetch posts', 500);
        }
    }
    

    // View specific post by slug
    public function show($slug)
    {
        try {
            $post = Post::with(['category', 'tags', 'user'])->where('slug', $slug)->firstOrFail();

            return ResponseHelper::success($post, 'Post fetched successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error('Post not found', 404);
        }
    }

    // Update post (only author or admin)
    public function update(PostRequest $request, $slug)
    {
        try {
            $post = Post::where('slug', $slug)->firstOrFail();

            $post->update($request->only('title', 'content', 'category_id'));

            if ($request->has('tags')) {
                $post->tags()->sync($request->tags);
            }

            return ResponseHelper::success($post, 'Post updated successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to update post', 500);
        }
    }

    // Delete post (only author or admin)
    public function destroy($slug)
    {
        try {
            $post = Post::where('slug', $slug)->firstOrFail();

            $post->delete();

            return ResponseHelper::success(null, 'Post deleted successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to delete post', 500);
        }
    }

    // Search and Filter posts
    public function search(Request $request)
    {
        try {
            $query = Post::with(['category', 'tags', 'user']);

            if ($request->filled('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('content', 'LIKE', "%{$request->keyword}%");
                });
            }

            if ($request->filled('category')) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            if ($request->filled('tag')) {
                $query->whereHas('tags', function ($q) use ($request) {
                    $q->where('slug', $request->tag);
                });
            }

            $posts = $query->where('status', 'published')->orderBy('created_at', 'desc')->paginate(10);
            return ResponseHelper::success($posts, 'Posts filtered successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to search posts', 500);
        }
    }
}
