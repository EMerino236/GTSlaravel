<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Sesion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'sesiones';

	public function scopeGetSesionesByIdCapacitacion($query,$id_capacitacion){
		$query->where('id_capacitacion','=',$id_capacitacion);
	}

	public function getSesionNumeroAttribute()
	{
	    return $this->attributes['numero_sesion'] .' - '. $this->attributes['fecha'];
	}

}