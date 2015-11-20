<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TareasOtBusquedaInformacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tareas_ot_busqueda_infos';
	protected $primaryKey = 'idtareas_ot_busqueda_info';

	public function scopeGetTareasXOt($query,$search_criteria)
	{
		$query->where('idot_busqueda_info','=',$search_criteria);
		return $query;
	}

	
	
}