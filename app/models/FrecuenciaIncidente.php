<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class FrecuenciaIncidente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'frecuencia_incidente';
}