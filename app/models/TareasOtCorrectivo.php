<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TareasOtCorrectivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tareas_ot_correctivos';
	protected $primaryKey = 'idtareas_ot_correctivo';

	public function scopeGetTareasXOtXActi($query,$idot_correctivo)
	{
		$query->where('idot_correctivo','=',$idot_correctivo);
		return $query;
	}

}