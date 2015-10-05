<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Tarea extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $primaryKey = 'idtareas';
	protected $table = 'tareas';

	public function scopeSearchTareaByIdTipoTarea($query,$search_criteria)
	{
		$query->where('idtipo_tarea','=',$search_criteria);
		return $query;
	}	
}