<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EspecificacionTecnica extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'especificacion_tecnica';
	protected $primaryKey = 'idespecificacion_tecnica';

	public function scopeGetEspecificacionTecnicaByFamiliaActivoInfo($query,$familia_activo)
	{
		$query->withTrashed()
			  ->join('tipo_especificacion_tecnica','tipo_especificacion_tecnica.idtipo_especificacion_tecnica','=','especificacion_tecnica.idtipo_especificacion_tecnica')			  			  
			  ->where('especificacion_tecnica.nombre_equipo','=',$familia_activo)
			  ->select('tipo_especificacion_tecnica.idtipo_especificacion_tecnica','especificacion_tecnica.*');
	  	return $query;
	}

}