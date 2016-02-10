<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Dimension extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'dimensiones';

	public function scopeSearchDimensiones($query,$search_nombre){

		$query->withTrashed();

		if($search_nombre != "")
		{
			$query->where('dimensiones.nombre','LIKE',"%$search_nombre%");
		}		
			  
	    $query->select('dimensiones.*');

		return $query;
	}

}