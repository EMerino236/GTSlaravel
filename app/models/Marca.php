<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Marca extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'marcas';
	protected $primaryKey = 'idmarca';

	public function scopeGetMarcasInfo($query)
	{
		$query->withTrashed()
			  ->select('marcas.*');
	  	return $query;
	}

	public function scopeSearchMarcasByNombre($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('marcas.nombre','LIKE',"%$search_criteria%");
	  	return $query;				  
	}

	public function scopeSearchMarcasById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('marcas.idmarca',"=",$search_criteria);
		return $query;
	}

}