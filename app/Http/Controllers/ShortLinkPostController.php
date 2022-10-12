<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class ShortLinkPostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Post $post)
    {
        return redirect("/post/{$post->slug}");
    }
}
