<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteInstalacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_instalaciones';
	protected $primaryKey = 'idreporte_instalacion';

	public function scopeSearchReporteEntornoConcluidoByCodigoCompra($query,$search_criteria)
	{
		$query->where('idtipo_reporte_instalacion','=','1')//tipo de reporte de instalacion 1 = entorno concluido
			  ->where('codigo_compra','=',$search_criteria);
		return $query;
	}

	public function scopeSearchReporteEntornoConcluidoByNumeroReporte($query,$abreviatura,$correlativo,$anho)
	{
		$query->where('numero_reporte_abreviatura','=',$abreviatura)
			  ->where('numero_reporte_correlativo','=',$correlativo)
			  ->where('numero_reporte_anho','=',$anho);
		return $query;
	}	
}