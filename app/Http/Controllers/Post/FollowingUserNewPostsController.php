<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowingUserNewPostsController extends Controller
{
    public function index(Request $request)
    {
        dd("asdasd");

        return response([
            'posts' => 'ok'
        ], 200);
    }
}
