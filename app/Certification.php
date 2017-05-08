<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'market_id',
        'reserved_date',
        'time',
        'status',
        'location',
        'item_info',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'market_id',
        'updated_at',
    ];

    /* Relationships */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function market()
    {
        if ($this->market_id != null) {
            return Market::find($this->market_id);
        }else{
            return null;
        }
    }
}
