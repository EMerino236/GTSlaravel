<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RepuestosOtCorrectivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'repuestos_ot_correctivo';
	protected $primaryKey = 'idrepuestos_ot_correctivo';

	public function scopeGetRepuestosXOtXActi($query,$idot_correctivo)
	{
		$query->where('idot_correctivo','=',$idot_correctivo);
		return $query;
	}

}