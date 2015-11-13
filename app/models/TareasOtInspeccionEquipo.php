<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TareasOtInspeccionEquipo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tareas_inspec_equipos';
	protected $primaryKey = 'idtareas_inspec_equipo';

	public function scopeGetTareasByFamiliaActivo($query,$idfamilia_activo)
	{
		$query->where('idfamilia_activo','=',$idfamilia_activo);
		return $query;
	}

	public function scopeGetTareaById($query,$idtarea){
		$query->where('idtareas_inspec_equipo','=',$idtarea);
		return $query;
	}
	
}