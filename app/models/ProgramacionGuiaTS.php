<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProgramacionGuiaTS extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'programacion_guia_ts';
	protected $primaryKey = 'id';

	/*
	function scopeGetTodosUsuarios($query,$anho)
	{
		$usuarios_cn = DB::table('programacion_reporte_cn')->distinct()->join('users','users.id','=','programacion_reporte_cn.iduser')
						->whereYear('programacion_reporte_cn.fecha','=',$anho)
						->select('programacion_reporte_cn.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$usuarios_etes = DB::table('programacion_reporte_etes')->distinct()->join('users','users.id','=','programacion_reporte_etes.iduser')
						->whereYear('programacion_reporte_etes.fecha','=',$anho)
						->select('programacion_reporte_etes.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$usuarios_paac = DB::table('programacion_reporte_paac')->distinct()->join('users','users.id','=','programacion_reporte_paac.iduser')
						->whereYear('programacion_reporte_paac.fecha','=',$anho)
						->select('programacion_reporte_paac.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$query = $usuarios_cn
				->union($usuarios_etes)
				->union($usuarios_paac)
				->distinct('iduser');
		return $query;
	}

	function scopeSearchTodosUsuarios($query,$anho,$search_usuario)
	{
		$usuarios_cn = DB::table('programacion_reporte_cn')->distinct()->join('users','users.id','=','programacion_reporte_cn.iduser')
						->whereNested(function($query) use($search_usuario){
						  		$query->where('users.nombre','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
						  })
						->whereYear('programacion_reporte_cn.fecha','=',$anho)
						->select('programacion_reporte_cn.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$usuarios_etes = DB::table('programacion_reporte_etes')->distinct()->join('users','users.id','=','programacion_reporte_etes.iduser')
						->whereNested(function($query) use($search_usuario){
						  		$query->where('users.nombre','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
						  })
						->whereYear('programacion_reporte_etes.fecha','=',$anho)
						->select('programacion_reporte_etes.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$usuarios_paac = DB::table('programacion_reporte_paac')->distinct()->join('users','users.id','=','programacion_reporte_paac.iduser')
						->whereNested(function($query) use($search_usuario){
						  		$query->where('users.nombre','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
						  })
						->whereYear('programacion_reporte_paac.fecha','=',$anho)
						->select('programacion_reporte_paac.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$query = $usuarios_cn
				->union($usuarios_etes)
				->union($usuarios_paac)
				->distinct('iduser');
		return $query;
	}
	*/

	//FALTA CAMBIAR
	function scopeGetProgramacionesReporteTS($query,$anho)
	{	
		
		$sql = 'select distinct if(p.idservicio is null,a.nombre,s.nombre) as servicio, p.iduser,
						enero.idreporte_CN as idreporte_cn_enero,DAY(enero.fecha) as enero, enero.idestado_programacion_reportes as idestado_programacion_reportes_enero, enero.idprogramacion_reporte_cn as idprogramacion_reporte_cn_enero,
						febrero.idreporte_CN as idreporte_cn_febrero,DAY(febrero.fecha) as febrero, febrero.idestado_programacion_reportes as idestado_programacion_reportes_febrero,febrero.idprogramacion_reporte_cn as idprogramacion_reporte_cn_febrero,
						marzo.idreporte_CN as idreporte_cn_marzo,DAY(marzo.fecha) as marzo, marzo.idestado_programacion_reportes as idestado_programacion_reportes_marzo,marzo.idprogramacion_reporte_cn as idprogramacion_reporte_cn_marzo,
						abril.idreporte_CN as idreporte_cn_abril,DAY(abril.fecha) as abril, abril.idestado_programacion_reportes as idestado_programacion_reportes_abril,abril.idprogramacion_reporte_cn as idprogramacion_reporte_cn_abril,
						mayo.idreporte_CN as idreporte_cn_mayo,DAY(mayo.fecha) as mayo, mayo.idestado_programacion_reportes as idestado_programacion_reportes_mayo,mayo.idprogramacion_reporte_cn as idprogramacion_reporte_cn_mayo,
						junio.idreporte_CN as idreporte_cn_junio,DAY(junio.fecha) as junio, junio.idestado_programacion_reportes as idestado_programacion_reportes_junio,junio.idprogramacion_reporte_cn as idprogramacion_reporte_cn_junio,
						julio.idreporte_CN as idreporte_cn_julio,DAY(julio.fecha) as julio, julio.idestado_programacion_reportes as idestado_programacion_reportes_julio,julio.idprogramacion_reporte_cn as idprogramacion_reporte_cn_julio,
						agosto.idreporte_CN as idreporte_cn_agosto,DAY(agosto.fecha) as agosto, agosto.idestado_programacion_reportes as idestado_programacion_reportes_agosto,agosto.idprogramacion_reporte_cn as idprogramacion_reporte_cn_agosto,
						setiembre.idreporte_CN as idreporte_cn_setiembre,DAY(setiembre.fecha) as setiembre, setiembre.idestado_programacion_reportes as idestado_programacion_reportes_setiembre,setiembre.idprogramacion_reporte_cn as idprogramacion_reporte_cn_setiembre,
						octubre.idreporte_CN as idreporte_cn_octubre,DAY(octubre.fecha) as octubre, octubre.idestado_programacion_reportes as idestado_programacion_reportes_octubre,octubre.idprogramacion_reporte_cn as idprogramacion_reporte_cn_octubre,
						noviembre.idreporte_CN as idreporte_cn_noviembre,DAY(noviembre.fecha) as noviembre, noviembre.idestado_programacion_reportes as idestado_programacion_reportes_noviembre,noviembre.idprogramacion_reporte_cn as idprogramacion_reporte_cn_noviembre,
						diciembre.idreporte_CN as idreporte_cn_diciembre,DAY(diciembre.fecha) as diciembre, diciembre.idestado_programacion_reportes as idestado_programacion_reportes_diciembre, diciembre.idprogramacion_reporte_cn as idprogramacion_reporte_cn_diciembre
				from programacion_reporte_cn p
					left join servicios s on s.idservicio = p.idservicio
					join areas a on a.idarea = p.idarea
					left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 1 and YEAR(p.fecha) = '.$anho.') enero
								on if(p.idservicio is null,enero.idservicio is null,enero.idservicio = p.idservicio) and enero.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 2 and YEAR(p.fecha) = '.$anho.') febrero
								on if(p.idservicio is null,febrero.idservicio is null,febrero.idservicio = p.idservicio) and febrero.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 3 and YEAR(p.fecha) = '.$anho.') marzo
								on if(p.idservicio is null,marzo.idservicio is null,marzo.idservicio = p.idservicio) and marzo.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 4 and YEAR(p.fecha) = '.$anho.') abril
								on if(p.idservicio is null,abril.idservicio is null,abril.idservicio = p.idservicio) and abril.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 5 and YEAR(p.fecha) = '.$anho.') mayo
								on if(p.idservicio is null,mayo.idservicio is null,mayo.idservicio = p.idservicio) and mayo.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 6 and YEAR(p.fecha) = '.$anho.') junio
								on if(p.idservicio is null,junio.idservicio is null,junio.idservicio = p.idservicio) and junio.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 7 and YEAR(p.fecha) = '.$anho.') julio
								on if(p.idservicio is null,julio.idservicio is null,julio.idservicio = p.idservicio) and julio.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 8 and YEAR(p.fecha) = '.$anho.') agosto
								on if(p.idservicio is null,agosto.idservicio is null,agosto.idservicio = p.idservicio) and agosto.idarea = p.idarea 
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 9 and YEAR(p.fecha) = '.$anho.') setiembre
								on if(p.idservicio is null,setiembre.idservicio is null,setiembre.idservicio = p.idservicio) and setiembre.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 10 and YEAR(p.fecha) = '.$anho.') octubre
								on if(p.idservicio is null,octubre.idservicio is null,octubre.idservicio = p.idservicio) and octubre.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 11 and YEAR(p.fecha) = '.$anho.') noviembre
								on if(p.idservicio is null,noviembre.idservicio is null,noviembre.idservicio = p.idservicio) and noviembre.idarea = p.idarea
						 left join (select r.idreporte_CN, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_cn
								from programacion_reporte_cn p left join reporte_cn r on p.idprogramacion_reporte_cn = r.idprogramacion_reporte_cn 
								where MONTH(p.fecha) = 12 and YEAR(p.fecha) = '.$anho.') diciembre
								on if(p.idservicio is null,diciembre.idservicio is null,diciembre.idservicio = p.idservicio) and diciembre.idarea = p.idarea
					where  YEAR(p.fecha) = '.$anho
				;

		$query = DB::select(DB::raw($sql));
		return $query;
	}

}