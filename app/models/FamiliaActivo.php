<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class FamiliaActivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'familia_activos';
	protected $primaryKey = 'idfamilia_activo';

	public function scopeGetFamiliaActivosInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_activos','tipo_activos.idtipo_activo','=','familia_activos.idtipo_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')			  
			  ->select('tipo_activos.nombre as nombre_tipo_activo','marcas.nombre as nombre_marca','familia_activos.*');
	    return $query;
	}

	public function scopeSearchFamiliaActivo($query,$search_nombre_equipo,$search_marca)
	{
		$query->withTrashed()
			  ->join('tipo_activos','tipo_activos.idtipo_activo','=','familia_activos.idtipo_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->whereNested(function($query) use ($search_nombre_equipo,$search_marca){
			  			$query->where('familia_activos.nombre_equipo','LIKE',"%$search_nombre_equipo%");			  		
			  });

			  if($search_marca != '0')
			  {
			  	$query->where('familia_activos.idmarca','=',$search_marca);
			  }

			  $query->select('tipo_activos.nombre as nombre_tipo_activo','marcas.nombre as nombre_marca','familia_activos.*');
		return $query;
	}

	public function scopeSearchFamiliaActivoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('familia_activos.idfamilia_activo',"=",$search_criteria);
		return $query;
	}

	public function scopeSearchFamiliaActivoByMarca($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('familia_activos.idmarca','=',$search_criteria);
	}

}