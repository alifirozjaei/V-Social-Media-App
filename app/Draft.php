<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = [
        'title',
        'content',
        'link,',
        'user_id,',
    ];

    public function getRouteKeyName()
    {
        return 'link';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
