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

    public function authorName(){
        return $this->author->name;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply(Reply $reply)
    {
        $this->replies()->create($reply);
    }
}
