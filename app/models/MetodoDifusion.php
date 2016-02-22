<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class MetodoDifusion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'metodo_difusion';

	public function scopeGetMetodos($query)
	{
		$query->withTrashed()
			  ->select('metodo_difusion.*');
		return $query;
	}

}