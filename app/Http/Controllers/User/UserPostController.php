<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    public function index(User $user)
    {
        $posts = $user->posts()->with(['user', 'categories'])->withCount('likes')->simplePaginate(4);
        return response([
            'posts' => $posts,
            'user' => $user->loadCount(['posts', 'followers', 'follows'])->append(['is_follow'])
        ], 200);
    }

    public function followingList(User $user)
    {
        $followings = $user->follows()->simplePaginate(10);
        return response([
            'followings' => $followings
        ], 200);
    }

    public function followerList(User $user)
    {
        $followers = $user->followers()->simplePaginate(10);
        return response([
            'followers' => $followers
        ], 200);
    }
}
