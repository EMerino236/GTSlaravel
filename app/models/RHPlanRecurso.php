<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RHPlanRecurso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'rh_planes_aprendizaje_recursos';

}