<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EtapaServicio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'etapa_servicio';

	public function scopeGetEtapaServiciosByIdTipoServicio($query,$idtipo_servicio,$identorno)
	{
		$query->join('entorno_asistencialxtipo_servicio','entorno_asistencialxtipo_servicio.id','=','etapa_servicio.identornoxtipo')		  
		      ->where('entorno_asistencialxtipo_servicio.idtipo','=',$idtipo_servicio)
		      ->where('entorno_asistencialxtipo_servicio.identorno','=',$identorno)
		      ->select('etapa_servicio.*');
		return $query;
	}

	public function scopeGetEtapaServiciosByIdEtapaServicio($query,$idetapa_servicio)
	{
		$query->join('entorno_asistencialxtipo_servicio','entorno_asistencialxtipo_servicio.id','=','etapa_servicio.identornoxtipo')
			  ->join('entorno_asistencial','entorno_asistencial.id','=','entorno_asistencialxtipo_servicio.identorno')			  
		      ->join('tipo_servicio','tipo_servicio.id','=','entorno_asistencialxtipo_servicio.idtipo')
		      ->where('etapa_servicio.id','=',$idetapa_servicio)
		      ->select('etapa_servicio.*','tipo_servicio.id as idtipo_servicio','entorno_asistencial.id as identorno','tipo_servicio.nombre as nombre_tipo_servicio');
		return $query;
	}
}