<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'size',
        'color',
        'inventory',
        'etc',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'product_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'product',
    ];

    /* Relationships */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /* Accessors */
    public function getStockAttribute()
    {
        $items = Item::where('option_id', $this->id)->where('order_id', '!=', null)->get();
        $buyed_count = 0;
        foreach ($items as $item) {
            if ($item->order->status != "작성중") {
                $buyed_count += $item->count;
            }
        }

        return ($this->inventory - $buyed_count);
    }
}
