<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PresupuestoCapacitacionActividad extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'presupuesto_capacitacion_actividades';

}