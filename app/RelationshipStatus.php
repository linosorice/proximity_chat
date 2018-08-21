<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationshipStatus extends Model
{
	protected $table = "relationship_status";
	
	protected $fillable = array('name');
}
