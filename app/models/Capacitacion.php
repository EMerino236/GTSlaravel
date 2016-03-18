<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Capacitacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'capacitaciones';

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

	public function tipo()
	{
		return $this->belongsTo('RHTipo', 'id_tipo');	
	}

	public function modalidad()
	{
		return $this->belongsTo('RHModalidad', 'id_modalidad');	
	}

	public function scopeSearchReporte($query,$search_nombre,$search_responsable,$search_departamento,$search_servicio_clinico,$search_fecha_ini,$search_fecha_fin)
	{
		$query->withTrashed();
			  
		if($search_nombre != "")
		{
			$query->where('capacitaciones.nombre','LIKE',"%$search_nombre%");
		}

		if($search_responsable != 0)
		{
			$query->where('capacitaciones.id_responsable', '=' ,$search_responsable);
		}

		if($search_departamento != 0)
		{
			$query->where('capacitaciones.id_departamento','=', $search_departamento);
		}

		if($search_servicio_clinico != 0)
		{
			$query->where('capacitaciones.id_servicio_clinico','=',$search_servicio_clinico);
		}

		if($search_fecha_ini != "")
		{
			$query->where('capacitaciones.fecha_ini', '>' ,date('Y-m-d',strtotime($search_fecha_ini)));
		}

		if($search_fecha_fin != "")
		{
			$query->where('capacitaciones.fecha_ini', '<' ,date('Y-m-d',strtotime($search_fecha_fin)));
		}
		
		return $query;
	}

	public function activo(){
		return $this->belongsTo('Activo','id_activo');
	}
}