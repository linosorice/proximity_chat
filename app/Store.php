<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	protected $table = "store";
	
	protected $fillable = array('company_id', 'name');
	
	public function company() {
		return $this->belongsTo('App\Company');
	}
	
	public function beacons() {
		return $this->hasMany('App\Beacon')->where('is_removed', 0);
	}
	
	public function qrcodes() {
		return $this->hasMany('App\QrC')->where('is_removed', 0);
	}
	
	public function groups() {
		return $this->hasMany('App\Group')->where('is_removed', 0);
	}
}
