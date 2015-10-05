<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoTarea extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $primaryKey = 'idtipo_tarea';
	protected $table = 'tipo_tareas';
	
	public function scopeSearchTipoTareas($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('nombre','LIKE',"%$search_criteria%")
			  ->select('nombre','descripcion');
		return $query;
	}

	public function scopeGetTipoTareasInfo($query)
	{
		$query->withTrashed();			  
		return $query;
	}

	public function scopeSearchTipoTareaById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('idtipo_tarea','=',$search_criteria);
		return $query;
	}	
}