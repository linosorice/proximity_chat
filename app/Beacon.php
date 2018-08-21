<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beacon extends Model
{
	protected $table = "beacon";
	
	protected $fillable = array('uuid', 'store_id');
	
	public function store() {
		return $this->belongsTo('App\Store');
	}
}
