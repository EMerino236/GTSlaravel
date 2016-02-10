<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteDesarrollo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reportes_desarrollo';

	public function servicio()
	{
		return $this->belongsTo('Servicio', 'id_servicio_clinico');
	}

	public function categoria()
	{
		return $this->belongsTo('ProyectoCategoria', 'id_categoria');
	}

	public function departamento()
	{
		return $this->belongsTo('Area', 'id_departamento');
	}

	public function responsable()
	{
		return $this->belongsTo('User', 'id_responsable');
	}

	public function indicador()
	{
		return $this->hasMany('ReporteDesarrolloIndicador','reporte_id');
	}

	public function scopeSearchReporte($query,$search_nombre,$search_categoria,$search_servicio_clinico,$search_departamento,$search_responsable,$search_fecha_ini,$search_fecha_fin)
	{
		$query->withTrashed();
			  
		if($search_nombre != "")
		{
			$query->where('reportes_desarrollo.nombre','LIKE',"%$search_nombre%");
		}

		if($search_categoria != 0)
		{
			$query->where('reportes_desarrollo.id_categoria','=',$search_categoria);
		}

		if($search_servicio_clinico != 0)
		{
			$query->where('reportes_desarrollo.id_servicio_clinico','=',$search_servicio_clinico);
		}

		if($search_departamento != 0)
		{
			$query->where('reportes_desarrollo.id_departamento','=', $search_departamento);
		}

		if($search_responsable != 0)
		{
			$query->where('reportes_desarrollo.id_responsable', '=' ,$search_responsable);
		}

		if($search_fecha_ini != "")
		{
			$query->where('reportes_desarrollo.fecha_ini', '>' ,date('Y-m-d',strtotime($search_fecha_ini)));
		}

		if($search_fecha_fin != "")
		{
			$query->where('reportes_desarrollo.fecha_ini', '<' ,date('Y-m-d',strtotime($search_fecha_fin)));
		}
		
		return $query;
	}


}