<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RepuestosOtPreventivos extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'repuestos_ot_preventivos';
	protected $primaryKey = 'idrepuestos_ot_preventivo';

	public function scopeGetRepuestosXOt($query,$idot_preventivo)
	{
		$query->where('idot_preventivo','=',$idot_preventivo);
		return $query;
	}

}