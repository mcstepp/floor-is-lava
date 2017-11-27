<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];
    protected $with = ['author', 'favorites'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
