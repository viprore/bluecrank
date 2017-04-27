<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seller_id',
        'category',
        'is_certied',
        'ad_title',
        'ad_status',
        'product_status',
        'price',
        'brand',
        'model',
        'is_direct',
        'direct_info',
        'is_ship',
        'ship_info',
        'is_trade',
        'trade_info',
        'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'seller_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
//        'user',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'selled_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_certied' => 'boolean',
        'is_direct' => 'boolean',
        'is_ship' => 'boolean',
        'is_trade' => 'boolean',
    ];

    /* Relationships */
    public function user()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function wants()
    {
        return $this->morphToMany('App\User', 'markkable');
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
