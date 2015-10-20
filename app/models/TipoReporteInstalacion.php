<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoReporteInstalacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_reporte_instalaciones';
	protected $primaryKey = 'idtipo_reporte_instalacion';
}