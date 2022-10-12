<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;
use App\Comment;

class Post extends Model
{

    use Sluggable;

    protected $guarded = [];
    protected $appends = [
        'is_bookmarked',
        'is_liked'
    ];

    static public function booted()
    {
        static::saving(function ($post) {
            $post->short_link = Str::random(10);
        });
    }

    static public function getImageDirectory()
    {
        return  '/images/posts/';
    }


    static public function getPublickDirectory()
    {
        return  public_path() . static::getImageDirectory();
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function parentComments()
    {
        return $this->comments()->whereNull('comment_id');
    }

    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    // public function likes()
    // {
    //     return $this->belongsToMany(User::class, 'likes');
    // }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getIsBookmarkedAttribute()
    {
        if (request()->user()) {
            $id = request()->user()->id;
        } else {
            $id = "";
        }
        return $this->bookmarks()
            ->where('user_id', $id)
            ->exists();
    }

    public function getIsLikedAttribute()
    {
        if (request()->user()) {
            $id = request()->user()->id;
        } else {
            $id = "";
        }
        return $this->likes()
            ->where('user_id', $id)
            ->exists();
    }

    public function getCategoriesTitleAttribute()
    {
        return $this->categories->pluck('title');
    }

    public function getImageAttribute()
    {
        return '/images/posts/' . $this->attributes['image'];
    }
}
