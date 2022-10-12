<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class HomePostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['user', 'categories'])
            ->withCount('likes')
            ->orderByDesc('created_at')
            ->simplePaginate(2);
        $posts->makeHidden(['content']);
        return response([
            'posts' => $posts
        ], 200);
    }

    public function randomPost()
    {
        $posts = Post::with(['user'])
            ->inRandomOrder()->take(4)->get();
        $posts->makeHidden(['content']);

        return response([
            'posts' => $posts
        ], 200);
    }
}
