<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TareasOtRetiro extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tareas_ot_retiros';
	protected $primaryKey = 'idtareas_ot_retiro';

	public function scopeGetTareasXOtXActi($query,$idtareas_ot_retiro)
	{
		$query->where('idtareas_ot_retiro','=',$idtareas_ot_retiro);
		return $query;
	}

}