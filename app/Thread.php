<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/threads/' . $this->id;
    }

    public function authorName()
    {
        return $this->author->name;
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // TODO: addReply(Reply $reply)
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
