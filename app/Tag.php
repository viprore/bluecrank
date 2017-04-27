<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'slug',
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

    public function articles()
    {
        return $this->morphedByMany('App\Article', 'taggable');
    }

    public function products()
    {
        return $this->morphedByMany('App\Product', 'taggable');
    }

    public function markets()
    {
        return $this->morphedByMany('App\Market', 'taggable');
    }
}
