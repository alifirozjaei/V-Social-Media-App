<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class Comment extends Model
{
    protected $guarded = [];

    public $with = ['replies', 'user'];

    public static function booted()
    {
        static::saving(function ($comment) {
            $comment->user_id = request()->user()->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // public function parent()
    // {
    //     return $this->belongsTo(Comment::class);
    // }

    public function replies()
    {
        return $this->hasMany(Comment::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    public function repliesDelete($comment)
    {
        $comment->delete();
        if ($comment->replies) {
            foreach ($comment->replies as  $value) {
                $this->repliesDelete($value);
            }
        }
    }
}
