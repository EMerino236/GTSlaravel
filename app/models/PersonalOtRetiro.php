<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PersonalOtRetiro extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'personal_ot_retiros';
	protected $primaryKey = 'idpersonal_ot_retiro';

	public function scopegetPersonalXOtXActi($query,$idot_retiro)
	{
		$query->where('idot_retiro','=',$idot_retiro);
		return $query;
	}

}