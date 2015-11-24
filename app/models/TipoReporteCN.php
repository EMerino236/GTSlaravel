<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoReporteCN extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_reporte_cn';
	protected $primaryKey = 'idtipo_reporte_CN';
}