<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public function parent() {
	    return $this->belongsTo('App\Comment', 'parent_id'); //get parent category
	}

	public function children() {
	    return $this->hasMany('App\Comment', 'parent_id'); //get all subs.
	}

	public function user() {
        return $this->belongsTo('App\Meetuser');
    }
}
