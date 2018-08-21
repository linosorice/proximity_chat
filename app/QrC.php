<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrC extends Model
{
	protected $table = "qrcode";
	
	protected $fillable = array('store_id', 'image');
	
	public function store() {
		return $this->belongsTo('App\Store');
	}
}
