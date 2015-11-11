<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Area extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table ="areas";
	protected $primaryKey = "idarea";

	public function scopeGetAreasInfo($query)
	{
		$query->join('tipo_areas','tipo_areas.idtipo_area','=','areas.idtipo_area')
			  ->select('tipo_areas.nombre as nombre_tipo_area','areas.*');
		return $query;
	}

	public function scopeSearchAreaById($query,$search_criteria)
	{
		$query->where('areas.idarea','=',$search_criteria);
		
		return $query;
	}

	public function scopeSearchAreas($query,$search_tipo_area,$search_nombre_area){

		$query->join('tipo_areas','tipo_areas.idtipo_area','=','areas.idtipo_area');

		if($search_tipo_area != "")
		{
			$query->where('areas.idtipo_area','=',$search_tipo_area);
		}

		if($search_nombre_area != "")
		{
			$query->where('areas.nombre','LIKE',"%$search_nombre_area%");
		}		
			  
	    $query->select('tipo_areas.nombre as nombre_tipo_area','areas.*');

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