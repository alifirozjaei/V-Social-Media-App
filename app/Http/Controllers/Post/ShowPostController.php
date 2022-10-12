<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ShowPostController extends Controller
{

    public function __invoke(Post $post)
    {
        $related_post = Post::with('user')
            ->where("id", '!=', $post->id)
            ->whereHas('categories', function ($query) use ($post) {
                $query->whereIn('categories.id', $post->categories->pluck('id'));
            })
            ->inRandomOrder()
            ->take(3)
            ->get();
        $post->load(['user', 'categories', 'parentComments'])
            ->loadCount(['comments', 'likes']);
        $post->user->append(['is_follow']);

        // add  to popular post
        Redis::zincrby(
            'trending_posts',
            1,
            json_encode([
                'title' => $post->title,
                'slug' => $post->slug,
                'user_name' => $post->user->name,
                'user_profile_src' => $post->user->profile_src
            ])
        );

        return response([
            'post' => $post,
            'related_post' => $related_post
        ], 200);
    }
}
