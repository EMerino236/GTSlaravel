<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AcuerdoConvenio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'acuerdos_convenios';

}