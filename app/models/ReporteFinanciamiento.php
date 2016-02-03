<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteFinanciamiento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_financiamiento';
	protected $primaryKey = 'id';

	public function servicio()
	{
		return $this->belongsTo('Servicio', 'id_servicio_clinico');
	}

	public function departamento()
	{
		return $this->belongsTo('Area', 'id_departamento');
	}

	public function responsable()
	{
		return $this->belongsTo('User', 'id_responsable');
	}

	public function cronogramas()
	{
		return $this->hasMany('ReporteFinanciamientoCronograma','id_reporte');
	}

	public function inversiones()
	{
		return $this->hasMany('ReporteFinanciamientoInversion','id_reporte');
	}

	public function scopeSearchReporte($query,$search_nombre,$search_categoria,$search_servicio_clinico,$search_departamento,$search_responsable)
	{
		$query->withTrashed();
			  
		if($search_nombre != "")
		{
			$query->where('reporte_financiamiento.nombre','LIKE',"%$search_nombre%");
		}

		if($search_categoria != 0)
		{
			$query->where('reporte_financiamiento.id_categoria','=',$search_categoria);
		}

		if($search_servicio_clinico != 0)
		{
			$query->where('reporte_financiamiento.id_servicio_clinico','=',$search_servicio_clinico);
		}

		if($search_departamento != 0)
		{
			$query->where('reporte_financiamiento.id_departamento','=', $search_departamento);
		}

		if($search_responsable != 0)
		{
			$query->where('reporte_financiamiento.id_responsable', '=' ,$search_responsable);
		}
		
		return $query;
	}

}