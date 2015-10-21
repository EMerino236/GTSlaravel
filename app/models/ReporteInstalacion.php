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
		$query->where('idtipo_reporte_instalacion','=','1')
			  ->where('numero_reporte_abreviatura','=',$abreviatura)
			  ->where('numero_reporte_correlativo','=',$correlativo)
			  ->where('numero_reporte_anho','=',$anho);
		return $query;
	}	

	public function scopeGetUltimoCodigoByTipoReporte($query,$tipo_reporte)
	{
		$query->where('idtipo_reporte_instalacion','=',$tipo_reporte)
			  ->orderBy('created_at','desc');
		return $query;
	}	

	public function scopeGetReportesInstalacionInfo($query)
	{
		$sql = 'select a.codigo_compra,
						CONCAT(u.apellido_pat," ",u.apellido_mat," ",u.nombre) as nombre_responsable,
						p.razon_social as nombre_proveedor,
						r.nombre as nombre_area,
						CONCAT(a.numero_reporte_abreviatura,a.numero_reporte_correlativo,"-",a.numero_reporte_anho) as rep_entorno_concluido,
						b.numero_reporte as rep_equipo_funcional,
						a.* 
				from reporte_instalaciones a 
     				 join areas r on a.idarea = r.idarea
     				 join proveedores p on a.idproveedor= p.idproveedor
     				 join users u on a.id_responsable= u.id
     				 left join (select 
     				 				CONCAT(a.numero_reporte_abreviatura,a.numero_reporte_correlativo,"-",a.numero_reporte_anho) as numero_reporte,
     				 				a.codigo_compra 
								from reporte_instalaciones a
								where a.idtipo_reporte_instalacion=2) b
								on b.codigo_compra = a.codigo_compra 
					 where a.idtipo_reporte_instalacion=1;';
		$query = DB::select(DB::raw($sql));
		return $query;
	}		
}