<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoCapacitacionRiesgos extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_capacitacion_riesgos';

	public function scopeGetTipos($query)
	{
		$query->withTrashed()
			  ->select('tipo_capacitacion_riesgos.*');
		return $query;
	}

}