<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RequerimientoClinico extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'requerimientos_clinicos';
	protected $primaryKey = 'id';

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

	public function estado()
	{
		return $this->belongsTo('RequerimientoClinicoEstado', 'id_estado');
	}

	public function reporte()
	{
		return $this->belongsTo('ReporteFinanciamiento', 'id_reporte');
	}

	public function scopeSearchRequerimiento($query,$search_nombre,$search_categoria,$search_servicio_clinico,$search_departamento,$search_tipo, $search_estado)
	{
		$query->withTrashed();
			  
		if($search_nombre != "")
		{
			$query->where('requerimientos_clinicos.nombre','LIKE',"%$search_nombre%");
		}

		if($search_categoria != 0)
		{
			$query->where('requerimientos_clinicos.id_categoria','=',$search_categoria);
		}

		if($search_servicio_clinico != 0)
		{
			$query->where('requerimientos_clinicos.id_servicio_clinico','=',$search_servicio_clinico);
		}

		if($search_departamento != 0)
		{
			$query->where('requerimientos_clinicos.id_departamento','=', $search_departamento);
		}

		if($search_tipo != 0)
		{
			$query->where('requerimientos_clinicos.tipo', '=' ,$search_tipo);
		}

		if($search_estado != 0)
		{
			$query->where('requerimientos_clinicos.id_estado', '=' ,$search_estado);
		}
		
		return $query;
	}

}