<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProyectoEntidad extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyectos_entidades';

}