<?php

namespace App\Http\Controllers\Comment;

use App\Comment;
use App\Events\CommentCreatedEvent;
use App\Events\CommentDeletedEvent;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => ['required'],
            'post_id' => ['required']
        ]);

        $post->comments()->save(
            $comment = new Comment($request->only('content'))
        );
        $comment->save();

        event(new CommentCreatedEvent($comment->load(['user', 'post', 'replies', 'parent'])));

        return response([
            'data' => $comment
        ], 200);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('destory', $comment);

        event(new CommentDeletedEvent($comment));
        $counts = $comment->replies->count();
        // $comment->delete();
        $comment->repliesDelete($comment);

        // Event::dispatch(new CommentDeletedEvent($comment));

        return response([
            'data' => 'ok'
        ], 200);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('destory', $comment);
        $request->validate([
            'content' => 'required'
        ]);
        $comment->content = $request->content;
        $comment->save();
        return  response([
            'content' => $request->content
        ], 200);
    }
}
