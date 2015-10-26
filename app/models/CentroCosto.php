<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CentroCosto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'centro_costos';	
	protected $primaryKey = "idcentro_costo";

	public function scopeGetCentroCostosInfo($query)
	{
		$query->withTrashed()
			  ->select('centro_costos.*');
		return $query;
	}

	public function scopeSearchCentroCostoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('centro_costos.idcentro_costo','=',$search_criteria);
		return $query;
	}

	public function scopeSearchCentroCostos($query,$search_criteria){
		$query->withTrashed()
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('centro_costos.nombre','LIKE',"%$search_criteria%");
			  })
			  ->select('centro_costos.*');
		return $query;
	}

	
	
	


}