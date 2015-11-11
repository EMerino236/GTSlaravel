<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajoInspeccionEquipoxActivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ot_inspec_equiposxactivos';
	protected $primaryKey = 'idot_inspec_equiposxactivo';

	public function scopeGetTareasXOtXActivo($query,$idot_preventivo)
	{
		$query->join('ot_inspec_equiposxactivos','ot_inspec_equiposxactivos.idtareas_ot_preventivo','=','ot_inspec_equiposxactivos.idtareas_ot_preventivo')
			  ->where('ot_inspec_equiposxactivos.idot_preventivo','=',$idot_preventivo)
			  ->select('ot_inspec_equiposxactivos.nombre as nombre_tarea','ot_inspec_equiposxactivos.*');
		return $query;
	}

}