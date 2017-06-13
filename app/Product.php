<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category',
        'ad_title',
        'ad_status',
        'ad_short_description',
        'price',
        'brand',
        'model',
        'description',
        'is_old'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [

    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
//        'selled_at'
    ];

    /* Relationships */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function wants()
    {
        return $this->morphToMany('App\User', 'markkable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /* Accessor */
    public function getWantsCountAttribute()
    {
        return (int) $this->wants->count();
    }

    public function getCommentsCountAttribute() {
        return (int) $this->comments->count();
    }
}
