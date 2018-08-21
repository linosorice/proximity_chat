<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = "role";
	
	protected $fillable = array('name');
	
	public function accounts() {
		return $this->hasMany('App\Account');
	}
}
