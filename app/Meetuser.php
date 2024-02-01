<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meetuser extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post','user_id');
    }
    public function followers()
	{
	    return $this->belongsToMany(
	        self::class, 
	        'follows',
	        'follow_id',
	        'user_id'
	    );
	}
	public function followees()
	{
	    return $this->belongsToMany(
	        self::class,
	        'follows',
	        'user_id',
	        'follow_id'
	    );
	}
}
