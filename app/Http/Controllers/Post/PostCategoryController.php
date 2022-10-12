<?php

namespace App\Http\Controllers\Post;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function __invoke(Category $category)
    {
        // $posts = Post::whereHas('categories', function ($query) use ($category) {
        //     return $query->where("slug", $category->slug);
        // })->get();

        $posts = $category->posts()->with(['user', 'categories'])->withCount('likes')->simplePaginate(4);

        return response([
            'posts' => $posts,
            'category' => $category->loadCount('posts')
        ], 200);
    }
}
