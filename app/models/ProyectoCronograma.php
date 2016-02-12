<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProyectoCronograma extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyectos_cronogramas';

}