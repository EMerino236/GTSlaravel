<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajoInspeccionEquipoxActivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ot_inspec_equiposxactivos';
	protected $primaryKey = 'idot_inspec_equiposxactivo';

	public function scopeGetOtInspeccionxActivo($query,$idot_inspec_equipo,$idactivo)
	{
		$query->where('ot_inspec_equiposxactivos.idot_inspec_equipo','=',$idot_inspec_equipo)
			  ->where('ot_inspec_equiposxactivos.idactivo','=',$idactivo);		
		return $query;
	}

	

}