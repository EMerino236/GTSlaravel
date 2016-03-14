<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProgramacionInternado extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'programaciones_internado';

	public function servicioClinico()
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

	public function scopeSearchReporte($query,$search_nombre,$search_servicio_clinico,$search_departamento,$search_responsable,$search_fecha_ini,$search_fecha_fin)
	{
		$query->withTrashed();
		
		if($search_nombre != "")
		{
			$query->where('programaciones_internado.nombre','LIKE',"%$search_nombre%");
		}

		if($search_servicio_clinico != 0)
		{
			$query->where('programaciones_internado.id_servicio_clinico','=',$search_servicio_clinico);
		}

		if($search_departamento != 0)
		{
			$query->where('programaciones_internado.id_departamento','=', $search_departamento);
		}

		if($search_responsable != 0)
		{
			$query->where('programaciones_internado.id_responsable', '=' ,$search_responsable);
		}

		if($search_fecha_ini != "")
		{
			$query->where('programaciones_internado.fecha_ini', '>' ,date('Y-m-d',strtotime($search_fecha_ini)));
		}

		if($search_fecha_fin != "")
		{
			$query->where('programaciones_internado.fecha_fin', '<' ,date('Y-m-d',strtotime($search_fecha_fin)));
		}
		
		return $query;
	}
}