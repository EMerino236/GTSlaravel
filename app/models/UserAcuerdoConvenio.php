<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UserAcuerdoConvenio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'users_acuerdos_convenios';

	public function acuerdoConvenio()
	{
		return $this->belongsTo('AcuerdoConvenio', 'idacuerdo_convenio');
	}

	public function user()
	{
		return $this->belongsTo('User', 'iduser');	
	}
	
}