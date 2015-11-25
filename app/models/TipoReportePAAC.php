<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoReportePAAC extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_reporte_paac';
	protected $primaryKey = 'idtipo_reporte_PAAC';
}