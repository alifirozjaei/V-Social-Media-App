<?php

namespace App\Http\Controllers\Comment;

use App\Comment;
use App\Events\ReplyCreatedEvent;
use App\Http\Controllers\Controller;
use App\Notifications\CommentReplyNotification;
use App\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReplyCommentController extends Controller
{

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required',
            'comment_id' => 'required|exists:comments,id'
        ]);

        $post->comments()->save(
            $reply = new Comment($request->only(['content', 'comment_id']))
        );

        event(new ReplyCreatedEvent($reply->load(['user', 'post', 'replies', 'parent'])));

        $reply->parent->user->notify(
            new CommentReplyNotification(
                $reply->parent->user,
                $request->user(),
                $post,
                $reply->parent,
                $reply
            )
        );


        return response(['data' => $reply], 200);
    }
}
