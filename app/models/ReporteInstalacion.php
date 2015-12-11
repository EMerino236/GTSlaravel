<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteInstalacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_instalaciones';
	protected $primaryKey = 'idreporte_instalacion';

	public function scopeSearchReporteInstalacionById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('idreporte_instalacion','=',$search_criteria);
		return $query;
	}	

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

	public function scopeSearchReporteInstalacionByNumeroReporte($query,$abreviatura,$correlativo,$anho)
	{
		$query->where('reporte_instalaciones.idtipo_reporte_instalacion','=','2')
			  ->where('numero_reporte_abreviatura','=',$abreviatura)
			  ->where('numero_reporte_correlativo','=',$correlativo)
			  ->where('numero_reporte_anho','=',$anho);
		return $query;
	}	

	public function scopeSearchReportes($query,$search_usuario_responsable,$search_codigo_compra,$search_proveedor,$search_area){
		
		$sql = 'select a.codigo_compra,
						CONCAT(u.apellido_pat," ",u.apellido_mat," ",u.nombre) as nombre_responsable,
						p.razon_social as nombre_proveedor,
						r.nombre as nombre_area,
						CONCAT(a.numero_reporte_abreviatura,a.numero_reporte_correlativo,"-",a.numero_reporte_anho) as rep_entorno_concluido,
						b.numero_reporte as rep_equipo_funcional,
						a.idreporte_instalacion as idrep_ent_conc,
						b.idrep_eq_func,
						a.deleted_at
				from reporte_instalaciones a 
     				 join areas r on a.idarea = r.idarea
     				 join proveedores p on a.idproveedor= p.idproveedor
     				 join users u on a.id_responsable= u.id 
     				 				and ((u.nombre LIKE \'%'.$search_usuario_responsable.'%\') 
     				 					 or (u.apellido_pat LIKE \'%'.$search_usuario_responsable.'%\')
     				 					 or (u.apellido_mat LIKE \'%'.$search_usuario_responsable.'%\')
     				 					 or (\''.$search_usuario_responsable.'\' = \'\'))
     				 left join (select 
     				 				CONCAT(a.numero_reporte_abreviatura,a.numero_reporte_correlativo,"-",a.numero_reporte_anho) as numero_reporte,
     				 				a.codigo_compra,a.idreporte_instalacion as idrep_eq_func 
								from reporte_instalaciones a
								where a.idtipo_reporte_instalacion=2) b
								on b.codigo_compra = a.codigo_compra 
					 where a.idtipo_reporte_instalacion=1
					 and ((a.codigo_compra LIKE \'%'.$search_codigo_compra.'%\') or (\''.$search_codigo_compra.'\' = \'\'))
					 and ((a.idproveedor = \''.$search_proveedor.'\') or (\''.$search_proveedor.'\' = \'\'))
					 and ((a.idarea = \''.$search_area.'\') or (\''.$search_area.'\' = \'\'))';
		$query = DB::select(DB::raw($sql));	
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
						a.idreporte_instalacion as idrep_ent_conc,
						b.idrep_eq_func,
						a.deleted_at
				from reporte_instalaciones a 
     				 join areas r on a.idarea = r.idarea
     				 join proveedores p on a.idproveedor= p.idproveedor
     				 join users u on a.id_responsable= u.id
     				 left join (select 
     				 				CONCAT(a.numero_reporte_abreviatura,a.numero_reporte_correlativo,"-",a.numero_reporte_anho) as numero_reporte,
     				 				a.codigo_compra,a.idreporte_instalacion as idrep_eq_func 
								from reporte_instalaciones a
								where a.idtipo_reporte_instalacion=2) b
								on b.codigo_compra = a.codigo_compra 
					 where a.idtipo_reporte_instalacion=1';
		$query = DB::select(DB::raw($sql));
		return $query;
	}		
}