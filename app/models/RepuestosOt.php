<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RepuestosOt extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'repuestos_ot';
	protected $primaryKey = 'idrepuestos_ot';

	public function scopeGetRepuestosXOtXActi($query,$idorden_trabajoxactivo)
	{
		$query->where('idorden_trabajoxactivo','=',$idorden_trabajoxactivo);
		return $query;
	}

}