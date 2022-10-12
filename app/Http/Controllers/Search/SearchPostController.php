<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class SearchPostController extends Controller
{
    public function index(Request $request, $post)
    {
        $posts = Post::where('title', 'LIKE', "%{$post}%")
            ->orWhere('description', 'LIKE', "%{$post}%")
            ->with(['user', 'categories'])
            ->withCount(['likes'])
            ->simplePaginate(4);
        $posts->makeHidden(['content']);
        return response([
            'posts' => $posts
        ], 200);
    }
}
