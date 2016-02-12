<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProyectoRiesgo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyectos_riesgos';

}