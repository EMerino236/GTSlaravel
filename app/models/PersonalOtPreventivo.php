<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PersonalOtPreventivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'personal_ot_preventivos';
	protected $primaryKey = 'idpersonal_ot_preventivo';

	public function scopeGetPersonalXOt($query,$idot_preventivo)
	{
		$query->where('idot_preventivo','=',$idot_preventivo);
		return $query;
	}

}