<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Area extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table ="areas";
	protected $primaryKey = "idarea";

	public function scopeGetAreasInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_areas','tipo_areas.idtipo_area','=','areas.idtipo_area')
			  ->select('tipo_areas.nombre as nombre_tipo_area','areas.*');
		return $query;
	}

	public function scopeSearchAreaById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('areas.idarea','=',$search_criteria);
		return $query;
	}

	public function scopeSearchAreas($query,$search_criteria){
		$query->withTrashed()
			  ->join('tipo_areas','tipo_areas.idtipo_area','=','areas.idtipo_area')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('areas.idtipo_area','LIKE',"%$search_criteria%");
			  })
			  ->select('tipo_areas.nombre as nombre_tipo_area','areas.*');
		return $query;
	}

	public function scopeGetPersonalActivo($query,$idarea){	
		return  $query = DB::select( DB::raw( "select CONCAT(users.nombre,users.apellido_pat) as nombre_responsable, id FROM users WHERE idarea = :idarea AND deleted_at IS NULL"), array(
   				'idarea' => $idarea,
 				));
		 		
	}

	public function scopeGetUserList($query,$idarea)
	{
		 return User::select(DB::raw('CONCAT(users.nombre," ",users.apellido_pat) as nombre_responsable'), 'id')
		 		->where('deleted_at',NULL)
		 		->where('idarea',$idarea)                        
   			 	->lists('nombre_responsable', 'id');
	}


	
}