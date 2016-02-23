<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PlanActividad extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'planes_aprendizaje_actividades';

}