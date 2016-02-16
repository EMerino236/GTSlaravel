<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetalleReporteCalibracion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'detalle_reporte_calibracion';
	
}