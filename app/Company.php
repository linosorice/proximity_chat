<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $table = "company";
	
	protected $fillable = array('name');
	
	public function accounts() {
		return $this->belongsToMany('App\Account', 'account_company', 'company_id', 'account_id');		
	}
	
	public function stores() {
		return $this->hasMany('App\Store')->where('is_removed', '0');		
	}
}
