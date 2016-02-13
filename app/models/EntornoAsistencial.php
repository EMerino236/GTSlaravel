<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EntornoAsistencial extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'entorno_asistencial';
}