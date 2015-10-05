<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Servicio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'servicios';
	protected $primaryKey = 'idservicio';

	public function scopeGetServiciosInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_servicios','tipo_servicios.idtipo_servicios','=','servicios.idtipo_servicios')
			  ->select('tipo_servicios.nombre as nombre_tipo_servicio','servicios.*');
		return $query;
	}

	public function scopeSearchServicioById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('servicios.idservicio','=',$search_criteria);
		return $query;
	}

	public function scopeSearchServicios($query,$search_criteria){
		$query->withTrashed()
			  ->join('tipo_servicios','tipo_servicios.idtipo_servicios','=','servicios.idtipo_servicios')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('tipo_servicios.idtipo_servicios','LIKE',"%$search_criteria%");
			  })
			  ->select('tipo_servicios.nombre as nombre_tipo_servicio','servicios.*');
		return $query;
	}

	public function scopeSearchServiciosClinicos($query,$search_criteria){
		$query->join('tipo_servicios','tipo_servicios.idtipo_servicios','=','servicios.idtipo_servicios')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('tipo_servicios.idtipo_servicios','LIKE',"%$search_criteria%");
			  })
			  ->select('servicios.nombre','idservicio');
		return $query;
	}

	public function scopeSearchServiciosClinicosByIdArea($query,$search_criteria){
		$query->join('tipo_servicios','tipo_servicios.idtipo_servicios','=','servicios.idtipo_servicios')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('servicios.idarea','=',$search_criteria)
			  			  ->where('servicios.idtipo_servicios','=',1);
			  })
			  ->select('servicios.nombre','idservicio');
		return $query;
	}



	


}