<?php

namespace App\Http\Controllers\Post;

use App\Bookmark;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // $post->bookmarks()->sync(
        //     $request->user()->id,
        //     false
        // );

        $bookmark = Bookmark::firstOrNew([
            'post_id' => $post->id,
            'user_id' => $request->user()->id
        ]);
        $bookmark->save();

        return response([
            'data' => 'ok'
        ], 200);
    }

    public function destroy(Request $request, Post $post)
    {
        // $post->bookmarks()->detach(
        //     $request->user()->id
        // );

        $bookmark = Bookmark::where(['post_id' => $post->id, 'user_id' => $request->user()->id]);
        $bookmark->delete();

        return response([
            'data' => 'ok'
        ], 200);
    }
}
