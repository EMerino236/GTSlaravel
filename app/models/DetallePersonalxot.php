<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetallePersonalxot extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddetalle_personalxot';

	public function scopeGetPersonalXOtXActi($query,$idorden_trabajoxactivo)
	{
		$query->where('idorden_trabajoxactivo','=',$idorden_trabajoxactivo);
		return $query;
	}

}