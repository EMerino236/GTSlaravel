<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PersonalExternoCapacitacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'personal_externos';

	public function scopeGetDetallePersonasInvolucradas($query,$id_capacitacion){
		$query->withTrashed()
			  ->where('personal_externos.id_capacitacion','=',$id_capacitacion);
	}
}