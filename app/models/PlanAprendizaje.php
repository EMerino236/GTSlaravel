<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PlanAprendizaje extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'planes_aprendizaje';

	public function categoria()
	{
		return $this->belongsTo('ProyectoCategoria', 'id_categoria');
	}

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

	public function proyecto()
	{
		return $this->belongsTo('Proyecto', 'id_proyecto');
	}

	public function actividades()
	{
		return $this->hasMany('PlanActividad', 'id_plan');
	}

	public function recursos()
	{
		return $this->hasMany('PlanRecurso', 'id_plan');
	}

	public function scopeSearchReporte($query,$search_nombre,$search_servicio_clinico,$search_departamento,$search_responsable,$search_fecha_ini,$search_fecha_fin)
	{
		$query->join('planes_aprendizaje_actividades','planes_aprendizaje.id','=','planes_aprendizaje_actividades.id_plan')->select('*')->withTrashed();
		
		if($search_nombre != "")
		{
			$query->where('planes_aprendizaje.nombre','LIKE',"%$search_nombre%");
		}

		if($search_servicio_clinico != 0)
		{
			$query->where('planes_aprendizaje.id_servicio_clinico','=',$search_servicio_clinico);
		}

		if($search_departamento != 0)
		{
			$query->where('planes_aprendizaje.id_departamento','=', $search_departamento);
		}

		if($search_responsable != 0)
		{
			$query->where('planes_aprendizaje.id_responsable', '=' ,$search_responsable);
		}

		if($search_fecha_ini != "")
		{
			$query->where('planes_aprendizaje_actividades.fecha', '>' ,date('Y-m-d',strtotime($search_fecha_ini)));
		}

		if($search_fecha_fin != "")
		{
			$query->where('planes_aprendizaje_actividades.fecha', '>' ,date('Y-m-d',strtotime($search_fecha_fin)));
		}
		
		return $query;
	}
}