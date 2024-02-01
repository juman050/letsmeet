<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user() {
        return $this->belongsTo('App\Meetuser');
    }
 //    public function parent() {
	//     return $this->belongsTo('App\Comment', 'parent_id'); //get parent category
	// }

	// public function children() {
	//     return $this->hasMany('App\Comment', 'parent_id'); //get all subs.
	// }
}
