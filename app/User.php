<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'confirm_code',
        'activated',
        'name',
        'email',
        'password',
        'phone',
        'facebook_id',
        'naver_id',
        'google_id',
        'kakao_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'confirm_code',
        'password',
        'remember_token',
        'activated',
        'updated_at',
        'facebook_id',
        'naver_id',
        'google_id',
        'kakao_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_login',];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['activated' => 'boolean',];

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Item::class);
    }

    public function ships()
    {
        return $this->hasMany(Ship::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function wantArticles()
    {
        return $this->morphedByMany('App\Article', 'markkable');
    }

    public function wantProducts()
    {
        return $this->morphedByMany('App\Product', 'markkable');
    }

    public function wantMarkets()
    {
        return $this->morphedByMany('App\Market', 'markkable');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /* Query Scopes */
    public function scopeSocialUser(\Illuminate\Database\Eloquent\Builder $query, $email)
    {
        return $query->whereEmail($email)->whereNull('password');
    }

    /* Helpers */

    public function isAdmin()
    {
        return ($this->id === 1) ? true : false;
    }

    public function isTester()
    {
        return ($this->id === 7457) ? true : false;
    }

    public function isSocialUser()
    {
        return is_null($this->password) && $this->activated;
    }
}
