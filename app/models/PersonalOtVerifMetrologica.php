<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PersonalOtVerifMetrologica extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'personal_ot_vmetrologicas';
	protected $primaryKey = 'idpersonal_ot_vmetrologica';

	public function scopeGetPersonalXOt($query,$idot_preventivo)
	{
		$query->where('idot_vmetrologica','=',$idot_preventivo);
		return $query;
	}

}