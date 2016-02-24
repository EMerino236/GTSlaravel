<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteSeguimiento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reportes_seguimiento';


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

	public function recursos()
	{
		return $this->hasMany('PlanRecurso', 'id_plan');
	}

	public function proyecto()
	{
		return $this->belongsTo('Proyecto', 'id_proyecto');
	}

	public function scopeSearchReporte($query,$search_nombre,$search_servicio_clinico,$search_departamento,$search_responsable,$search_fecha_ini,$search_fecha_fin)
	{
		$query->withTrashed();
		
		if($search_nombre != "")
		{
			$query->where('reportes_seguimiento.nombre','LIKE',"%$search_nombre%");
		}

		if($search_servicio_clinico != 0)
		{
			$query->where('reportes_seguimiento.id_servicio_clinico','=',$search_servicio_clinico);
		}

		if($search_departamento != 0)
		{
			$query->where('reportes_seguimiento.id_departamento','=', $search_departamento);
		}

		if($search_responsable != 0)
		{
			$query->where('reportes_seguimiento.id_responsable', '=' ,$search_responsable);
		}

		if($search_fecha_ini != "")
		{
			$query->where('reportes_seguimiento.updated_at', '>' ,date('Y-m-d',strtotime($search_fecha_ini)));
		}

		if($search_fecha_fin != "")
		{
			$query->where('reportes_seguimiento.updated_at', '<' ,date('Y-m-d',strtotime($search_fecha_fin)));
		}
		
		return $query;
	}
}