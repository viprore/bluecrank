<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blurb extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'target',
        'link',
        'is_blank',
        'title',
        'text1',
        'text2',
        'order'
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
