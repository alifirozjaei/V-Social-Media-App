<?php

namespace App;

use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Illuminate\support\Str;
use App\Draft;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', "username",
        "bio", 'profile',
        "email_on_follow",
        "email_on_like",
        "email_on_reply"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_src', 'is_follow'
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function getProfileSrcAttribute()
    {
        $profileImage =  Str::beforeLast($this->profile, '?');
        return $this->profile && File::exists(public_path('/profiles/' . $profileImage))
            ? '/profiles/' . $this->profile : '/images/avatar2.webp';
    }

    public function drafts()
    {
        return $this->hasMany(Draft::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Post::class, 'bookmarks');
    }

    public function follows()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'user_id',
            'following_id'
        );
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'following_id',
            'user_id'
        );
    }

    public function getIsFollowAttribute()
    {
        return $this->followers()
            ->where('user_id', optional(request()->user())->id)
            ->exists();

        // return DB::table('follows')->where([
        //     'user_id' => optional(request()->user())->id,
        //     'following_id' => $this->id
        // ])->exists();
    }
}
