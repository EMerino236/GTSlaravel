<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TareaOtPreventivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tareas_ot_preventivos';
	protected $primaryKey = 'idtareas_ot_preventivo';

	public function scopeSearchTareaByIdTipoTarea($query,$search_criteria)
	{
		$query->where('idtipo_tarea','=',$search_criteria);
		return $query;
	}

	public function scopeGetTareasByFamiliaActivo($query,$idfamilia_activo)
	{
		$query->where('idfamilia_activo','=',$idfamilia_activo);
		return $query;
	}
	
}