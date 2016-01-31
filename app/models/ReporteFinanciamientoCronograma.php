<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteFinanciamientoCronograma extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_financiamiento_cronogramas';
	protected $primaryKey = 'id';

}