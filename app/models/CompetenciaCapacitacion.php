<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CompetenciaCapacitacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'competencias_generadas';

	public function scopeGetCompetenciasByIdSesion($query,$id_sesion){
		$query->where('id_sesion','=',$id_sesion);
	}
	
}