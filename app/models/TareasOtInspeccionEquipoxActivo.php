<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TareasOtInspeccionEquipoxActivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ot_inspec_equiposxactivosxtareas_inspec_equipo';
	protected $primaryKey = 'idot_inspec_equiposxactivosxtareas_inspec_equipo';

	public function scopeGetTareasxInspeccionxActivo($query,$idot_inspeccionxactivo){
		$query->where('ot_inspec_equiposxactivosxtareas_inspec_equipo.idot_inspec_equiposxactivo','=',$idot_inspeccionxactivo);
		return $query;
	}
	
}