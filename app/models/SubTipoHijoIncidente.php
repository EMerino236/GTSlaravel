<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SubTipoHijoIncidente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'subtipohijo_incidente';
	
	public function scopeGetSubTiposByIdSubtipoPadre($query,$idsubtipopadre)
	{
		$query->where('idsubtipopadre_incidente','=',$idsubtipopadre);
		return $query;
	}
	
}