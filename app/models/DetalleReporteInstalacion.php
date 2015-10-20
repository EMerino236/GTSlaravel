<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetalleReporteInstalacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'detalle_reporte_instalaciones';
	protected $primaryKey = 'iddetalle_reporte_instalacion';

	
}