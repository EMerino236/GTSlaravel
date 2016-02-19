<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PresupuestoActividad extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'presupuestos_actividades';

}