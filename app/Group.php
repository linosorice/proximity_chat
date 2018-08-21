<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $table = "group";
	
	protected $fillable = array('name');
	
	public function beacons() {
		return $this->belongsToMany('App\Beacon', 'group_beacon', 'group_id', 'beacon_id');		
	}
	
	public function qrcodes() {
		return $this->belongsToMany('App\QrC', 'group_qrcode', 'group_id', 'qrcode_id');		
	}
	
	public function store() {
		return $this->belongsTo('App\Store');
	}
	
	public function users() {
		return $this->belongsToMany('App\User', 'group_user', 'group_id', 'user_id');		
	}
}
