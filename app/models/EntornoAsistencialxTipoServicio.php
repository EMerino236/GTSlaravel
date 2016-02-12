<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EntornoAsistencialxTipoServicio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'entorno_asistencialxtipo_servicio';

	public function scopeGetTipoServiciosByIdEntornoAsistencial($query,$identorno_asistencial)
	{
		$query->join('entorno_asistencial','entorno_asistencial.id','=','entorno_asistencialxtipo_servicio.identorno')
			  ->join('tipo_servicio','tipo_servicio.id','=','entorno_asistencialxtipo_servicio.idtipo')
			  ->where('entorno_asistencial.id','=',$identorno_asistencial);
		return $query;
	}
}