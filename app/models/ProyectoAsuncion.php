<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProyectoAsuncion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyectos_asunciones';

}