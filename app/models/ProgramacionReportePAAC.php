<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProgramacionReportePAAC extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'programacion_reporte_paac';
	protected $primaryKey = 'idprogramacion_reporte_paac';

	function scopeGetProgramacionesReportePAAC($query,$anho)
	{	
		
		$sql = 'select distinct if(p.idservicio is null,a.nombre,s.nombre) as servicio, p.iduser,
						enero.idreporte_PAAC as idreporte_paac_enero,DAY(enero.fecha) as enero, enero.idestado_programacion_reportes as idestado_programacion_reportes_enero, enero.idprogramacion_reporte_paac as idprogramacion_reporte_paac_enero,
						febrero.idreporte_PAAC as idreporte_paac_febrero,DAY(febrero.fecha) as febrero, febrero.idestado_programacion_reportes as idestado_programacion_reportes_febrero, febrero.idprogramacion_reporte_paac as idprogramacion_reporte_paac_febrero,
						marzo.idreporte_PAAC as idreporte_paac_marzo,DAY(marzo.fecha) as marzo, marzo.idestado_programacion_reportes as idestado_programacion_reportes_marzo, marzo.idprogramacion_reporte_paac as idprogramacion_reporte_paac_marzo,
						abril.idreporte_PAAC as idreporte_paac_abril,DAY(abril.fecha) as abril, abril.idestado_programacion_reportes as idestado_programacion_reportes_abril, abril.idprogramacion_reporte_paac as idprogramacion_reporte_paac_abril,
						mayo.idreporte_PAAC as idreporte_paac_mayo,DAY(mayo.fecha) as mayo, mayo.idestado_programacion_reportes as idestado_programacion_reportes_mayo, mayo.idprogramacion_reporte_paac as idprogramacion_reporte_paac_mayo,
						junio.idreporte_PAAC as idreporte_paac_junio,DAY(junio.fecha) as junio, junio.idestado_programacion_reportes as idestado_programacion_reportes_junio, junio.idprogramacion_reporte_paac as idprogramacion_reporte_paac_junio,
						julio.idreporte_PAAC as idreporte_paac_julio,DAY(julio.fecha) as julio, julio.idestado_programacion_reportes as idestado_programacion_reportes_julio, julio.idprogramacion_reporte_paac as idprogramacion_reporte_paac_julio,
						agosto.idreporte_PAAC as idreporte_paac_agosto,DAY(agosto.fecha) as agosto, agosto.idestado_programacion_reportes as idestado_programacion_reportes_agosto, agosto.idprogramacion_reporte_paac as idprogramacion_reporte_paac_agosto,
						setiembre.idreporte_PAAC as idreporte_paac_setiembre,DAY(setiembre.fecha) as setiembre, setiembre.idestado_programacion_reportes as idestado_programacion_reportes_setiembre, setiembre.idprogramacion_reporte_paac as idprogramacion_reporte_paac_setiembre,
						octubre.idreporte_PAAC as idreporte_paac_octubre,DAY(octubre.fecha) as octubre, octubre.idestado_programacion_reportes as idestado_programacion_reportes_octubre, octubre.idprogramacion_reporte_paac as idprogramacion_reporte_paac_octubre,
						noviembre.idreporte_PAAC as idreporte_paac_noviembre,DAY(noviembre.fecha) as noviembre, noviembre.idestado_programacion_reportes as idestado_programacion_reportes_noviembre, noviembre.idprogramacion_reporte_paac as idprogramacion_reporte_paac_noviembre,
						diciembre.idreporte_PAAC as idreporte_paac_diciembre,DAY(diciembre.fecha) as diciembre, diciembre.idestado_programacion_reportes as idestado_programacion_reportes_diciembre, diciembre.idprogramacion_reporte_paac as idprogramacion_reporte_paac_diciembre
				from programacion_reporte_paac p
					left join servicios s on s.idservicio = p.idservicio
					join areas a on a.idarea = p.idarea
					left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 1 and YEAR(p.fecha) = '.$anho.') enero
								on if(p.idservicio is null,enero.idservicio is null,enero.idservicio = p.idservicio) and enero.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 2 and YEAR(p.fecha) = '.$anho.') febrero
								on if(p.idservicio is null,febrero.idservicio is null,febrero.idservicio = p.idservicio) and febrero.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 3 and YEAR(p.fecha) = '.$anho.') marzo
								on if(p.idservicio is null,marzo.idservicio is null,marzo.idservicio = p.idservicio) and marzo.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 4 and YEAR(p.fecha) = '.$anho.') abril
								on if(p.idservicio is null,abril.idservicio is null,abril.idservicio = p.idservicio) and abril.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 5 and YEAR(p.fecha) = '.$anho.') mayo
								on if(p.idservicio is null,mayo.idservicio is null,mayo.idservicio = p.idservicio) and mayo.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 6 and YEAR(p.fecha) = '.$anho.') junio
								on if(p.idservicio is null,junio.idservicio is null,junio.idservicio = p.idservicio) and junio.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 7 and YEAR(p.fecha) = '.$anho.') julio
								on if(p.idservicio is null,julio.idservicio is null,julio.idservicio = p.idservicio) and julio.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 8 and YEAR(p.fecha) = '.$anho.') agosto
								on if(p.idservicio is null,agosto.idservicio is null,agosto.idservicio = p.idservicio) and agosto.idarea = p.idarea 
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 9 and YEAR(p.fecha) = '.$anho.') setiembre
								on if(p.idservicio is null,setiembre.idservicio is null,setiembre.idservicio = p.idservicio) and setiembre.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 10 and YEAR(p.fecha) = '.$anho.') octubre
								on if(p.idservicio is null,octubre.idservicio is null,octubre.idservicio = p.idservicio) and octubre.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 11 and YEAR(p.fecha) = '.$anho.') noviembre
								on if(p.idservicio is null,noviembre.idservicio is null,noviembre.idservicio = p.idservicio) and noviembre.idarea = p.idarea
						 left join (select r.idreporte_PAAC, p.fecha as fecha, p.idservicio, p.idarea, p.idestado_programacion_reportes, p.idprogramacion_reporte_paac
								from programacion_reporte_paac p left join reporte_paac r on p.idprogramacion_reporte_paac = r.idprogramacion_reporte_paac 
								where MONTH(p.fecha) = 12 and YEAR(p.fecha) = '.$anho.') diciembre
								on if(p.idservicio is null,diciembre.idservicio is null,diciembre.idservicio = p.idservicio) and diciembre.idarea = p.idarea
					where YEAR(p.fecha) = '.$anho
				;

		$query = DB::select(DB::raw($sql));
		return $query;
	}
}