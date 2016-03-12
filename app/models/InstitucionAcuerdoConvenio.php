<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InstitucionAcuerdoConvenio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'instituciones_acuerdos_convenios';

	public function acuerdoConvenio()
	{
		return $this->belongsTo('AcuerdoConvenio', 'idacuerdo_convenio');
	}
	
}