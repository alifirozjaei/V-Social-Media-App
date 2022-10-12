<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class FollowingPostController extends Controller
{
    public function index(Request $request)
    {
        $followingIds = $request->user()
            ->follows->pluck('id');
        $posts = Post::with(['user'])
            ->whereIn('user_id', $followingIds)
            ->latest()
            ->take(3)
            ->get();
        return response([
            'posts' => $posts,
        ], 200);
    }

    public function newFollowingPosts(Request $request)
    {
        $followingIds = $request->user()
            ->follows->pluck('id');
        $posts = Post::with(['user'])
            ->whereIn('user_id', $followingIds)
            ->latest()
            ->simplePaginate(4);
        return response([
            'posts' => $posts,
        ], 200);
    }
}
