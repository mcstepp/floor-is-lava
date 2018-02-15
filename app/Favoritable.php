<?php
/**
 * Created on 10/2/17
 */

namespace App;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleting(function ($model){
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }

    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        // filter over the collection, trigger the delete on each instance of the model

        /*$this->favorites()->where($attributes)->get()->each(function($favorite){
            $favorite->delete();
        });*/

        $this->favorites()->where($attributes)->get()->each->delete();

    }

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}