<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProgramacionReporteETES extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'programacion_reporte_etes';
	protected $primaryKey = 'idprogramacion_reporte_etes';

	function scopeGetProgramacionesReporteETES($query,$anho)
	{	
		
		$sql = 'select distinct p.nombre_reporte, p.iduser,
						enero.idreporte_ETES as idreporte_etes_enero,DAY(enero.fecha) as enero, enero.idestado_programacion_reportes as idestado_programacion_reportes_enero, enero.idprogramacion_reporte_etes as idprogramacion_reporte_etes_enero,
						febrero.idreporte_ETES as idreporte_etes_febrero,DAY(febrero.fecha) as febrero, febrero.idestado_programacion_reportes as idestado_programacion_reportes_febrero, febrero.idprogramacion_reporte_etes as idprogramacion_reporte_etes_febrero,
						marzo.idreporte_ETES as idreporte_etes_marzo,DAY(marzo.fecha) as marzo, marzo.idestado_programacion_reportes as idestado_programacion_reportes_marzo, marzo.idprogramacion_reporte_etes as idprogramacion_reporte_etes_marzo,
						abril.idreporte_ETES as idreporte_etes_abril,DAY(abril.fecha) as abril, abril.idestado_programacion_reportes as idestado_programacion_reportes_abril, abril.idprogramacion_reporte_etes as idprogramacion_reporte_etes_abril,
						mayo.idreporte_ETES as idreporte_etes_mayo,DAY(mayo.fecha) as mayo, mayo.idestado_programacion_reportes as idestado_programacion_reportes_mayo, mayo.idprogramacion_reporte_etes as idprogramacion_reporte_etes_mayo,
						junio.idreporte_ETES as idreporte_etes_junio,DAY(junio.fecha) as junio, junio.idestado_programacion_reportes as idestado_programacion_reportes_junio, junio.idprogramacion_reporte_etes as idprogramacion_reporte_etes_junio,
						julio.idreporte_ETES as idreporte_etes_julio,DAY(julio.fecha) as julio, julio.idestado_programacion_reportes as idestado_programacion_reportes_julio, julio.idprogramacion_reporte_etes as idprogramacion_reporte_etes_julio,
						agosto.idreporte_ETES as idreporte_etes_agosto,DAY(agosto.fecha) as agosto, agosto.idestado_programacion_reportes as idestado_programacion_reportes_agosto, agosto.idprogramacion_reporte_etes as idprogramacion_reporte_etes_agosto,
						setiembre.idreporte_ETES as idreporte_etes_setiembre,DAY(setiembre.fecha) as setiembre, setiembre.idestado_programacion_reportes as idestado_programacion_reportes_setiembre, setiembre.idprogramacion_reporte_etes as idprogramacion_reporte_etes_setiembre,
						octubre.idreporte_ETES as idreporte_etes_octubre,DAY(octubre.fecha) as octubre, octubre.idestado_programacion_reportes as idestado_programacion_reportes_octubre, octubre.idprogramacion_reporte_etes as idprogramacion_reporte_etes_octubre,
						noviembre.idreporte_ETES as idreporte_etes_noviembre,DAY(noviembre.fecha) as noviembre, noviembre.idestado_programacion_reportes as idestado_programacion_reportes_noviembre, noviembre.idprogramacion_reporte_etes as idprogramacion_reporte_etes_noviembre,
						diciembre.idreporte_ETES as idreporte_etes_diciembre,DAY(diciembre.fecha) as diciembre, diciembre.idestado_programacion_reportes as idestado_programacion_reportes_diciembre, diciembre.idprogramacion_reporte_etes as idprogramacion_reporte_etes_diciembre
				from programacion_reporte_etes p
					left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 1 and YEAR(p.fecha) = '.$anho.') enero
								on enero.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 2 and YEAR(p.fecha) = '.$anho.') febrero
								on febrero.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 3 and YEAR(p.fecha) = '.$anho.') marzo
								on marzo.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 4 and YEAR(p.fecha) = '.$anho.') abril
								on abril.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 5 and YEAR(p.fecha) = '.$anho.') mayo
								on mayo.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 6 and YEAR(p.fecha) = '.$anho.') junio
								on junio.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 7 and YEAR(p.fecha) = '.$anho.') julio
								on julio.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 8 and YEAR(p.fecha) = '.$anho.') agosto
								on agosto.nombre_reporte = p.nombre_reporte 
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 9 and YEAR(p.fecha) = '.$anho.') setiembre
								on setiembre.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 10 and YEAR(p.fecha) = '.$anho.') octubre
								on octubre.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 11 and YEAR(p.fecha) = '.$anho.') noviembre
								on noviembre.nombre_reporte = p.nombre_reporte
						 left join (select r.idreporte_ETES, p.fecha as fecha, p.nombre_reporte, p.idestado_programacion_reportes, p.idprogramacion_reporte_etes
								from programacion_reporte_etes p left join reporte_etes r on p.idprogramacion_reporte_etes = r.idprogramacion_reporte_etes 
								where MONTH(p.fecha) = 12 and YEAR(p.fecha) = '.$anho.') diciembre
								on diciembre.nombre_reporte = p.nombre_reporte
					where  YEAR(p.fecha) = '.$anho
				;

		$query = DB::select(DB::raw($sql));
		return $query;
	}
}