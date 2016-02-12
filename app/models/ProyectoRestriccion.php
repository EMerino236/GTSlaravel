<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProyectoRestriccion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyectos_restricciones';

}