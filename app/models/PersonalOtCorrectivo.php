<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PersonalOtCorrectivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'personal_ot_correctivos';
	protected $primaryKey = 'idpersonal_ot_correctivo';

	public function scopegetPersonalXOtXActi($query,$idot_correctivo)
	{
		$query->where('idot_correctivo','=',$idot_correctivo);
		return $query;
	}

}