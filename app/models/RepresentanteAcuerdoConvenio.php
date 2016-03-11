<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RepresentanteAcuerdoConvenio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'representantes_acuerdos_convenios';

	public function acuerdoConvenio()
	{
		return $this->belongsTo('AcuerdoConvenio', 'idacuerdo_convenio');
	}
	
}