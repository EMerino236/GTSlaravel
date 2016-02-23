<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PlanRecurso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'planes_aprendizaje_recursos';

}