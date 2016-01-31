<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteFinanciamientoInversion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_financiamiento_inversiones';
	protected $primaryKey = 'id';

}