<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProyectoRequerimiento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyectos_requerimientos';

}