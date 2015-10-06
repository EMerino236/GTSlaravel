<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajosxactivoxtarea extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ordenes_trabajosxactivosxtareas';
	protected $primaryKey = 'idorden_trabajoxactivoxtarea';

	public function scopeGetTareasXOtXActi($query,$idorden_trabajoxactivo)
	{
		$query->join('tareas','tareas.idtareas','=','ordenes_trabajosxactivosxtareas.idtarea')
			  ->where('ordenes_trabajosxactivosxtareas.idorden_trabajoxactivo','=',$idorden_trabajoxactivo)
			  ->select('tareas.nombre as nombre_tarea','tareas.descripcion as descripcion_tarea','ordenes_trabajosxactivosxtareas.*');
		return $query;
	}

}