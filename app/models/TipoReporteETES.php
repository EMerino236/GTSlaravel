<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoReporteETES extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_reporte_etes';
	protected $primaryKey = 'idtipo_reporte_ETES';
}