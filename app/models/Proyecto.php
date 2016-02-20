<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Proyecto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyectos';

	public function requerimientoClinico()
	{
		return $this->belongsTo('RequerimientoClinico', 'id_requerimiento');
	}

	public function categoria()
	{
		return $this->belongsTo('ProyectoCategoria', 'id_categoria');
	}

	public function servicio()
	{
		return $this->belongsTo('Servicio', 'id_servicio_clinico');
	}

	public function departamento()
	{
		return $this->belongsTo('Area', 'id_departamento');
	}

	public function alcance()
	{
		return $this->belongsTo('Alcance', 'id_alcance');
	}

	public function presupuesto()
	{
		return $this->belongsTo('Presupuesto', 'id_presupuesto');
	}

	public function cronograma()
	{
		return $this->belongsTo('Cronograma', 'id_cronograma');
	}

	public function responsable()
	{
		return $this->belongsTo('User', 'id_responsable');
	}

	public function requerimientos()
	{
		return $this->hasMany('ProyectoRequerimiento', 'id_proyecto');
	}

	public function asunciones()
	{
		return $this->hasMany('ProyectoAsuncion', 'id_proyecto');
	}

	public function restricciones()
	{
		return $this->hasMany('ProyectoRestriccion', 'id_proyecto');
	}

	public function riesgos()
	{
		return $this->hasMany('ProyectoRiesgo', 'id_proyecto');
	}

	public function cronogramas()
	{
		return $this->hasMany('ProyectoCronograma', 'id_proyecto');
	}

	public function presupuestos()
	{
		return $this->hasMany('ProyectoPresupuesto', 'id_proyecto');
	}

	public function personal()
	{
		return $this->hasMany('ProyectoPersonal', 'id_proyecto');
	}

	public function entidades()
	{
		return $this->hasMany('ProyectoEntidad', 'id_proyecto');
	}

	public function aprobaciones()
	{
		return $this->hasMany('ProyectoAprobacion', 'id_proyecto');
	}

	public function scopeSearchReporte($query,$search_nombre,$search_categoria,$search_servicio_clinico,$search_departamento,$search_responsable,$search_fecha_ini,$search_fecha_fin)
	{
		$query->withTrashed();
			  
		if($search_nombre != "")
		{
			$query->where('proyectos.nombre','LIKE',"%$search_nombre%");
		}

		if($search_categoria != 0)
		{
			$query->where('proyectos.id_categoria','=',$search_categoria);
		}

		if($search_servicio_clinico != 0)
		{
			$query->where('proyectos.id_servicio_clinico','=',$search_servicio_clinico);
		}

		if($search_departamento != 0)
		{
			$query->where('proyectos.id_departamento','=', $search_departamento);
		}

		if($search_responsable != 0)
		{
			$query->where('proyectos.id_responsable', '=' ,$search_responsable);
		}

		if($search_fecha_ini != "")
		{
			$query->where('proyectos.fecha_ini', '>' ,date('Y-m-d',strtotime($search_fecha_ini)));
		}

		if($search_fecha_fin != "")
		{
			$query->where('proyectos.fecha_ini', '<' ,date('Y-m-d',strtotime($search_fecha_fin)));
		}
		
		return $query;
	}
}