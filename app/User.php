<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	protected $table = "user";
	
	protected $fillable = array('name');
	
	public function relationship_status() {
		return $this->belongsTo('App\RelationshipStatus');
	}
}
