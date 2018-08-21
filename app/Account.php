<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

//class Account extends Model
class Account extends Model implements Authenticatable
{
	use AuthenticableTrait;	
	
	protected $table = "account";
	
	protected $fillable = array('name', 'email', 'password', 'role_id');
	
	public function role() {
		return $this->belongsTo('App\Role');
	}
	
	public function companies() {
		return $this->belongsToMany('App\Company', 'account_company', 'account_id', 'company_id');		
	}
}
