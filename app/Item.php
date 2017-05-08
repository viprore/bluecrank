<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'count',
    ];

    /* Relationships */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
