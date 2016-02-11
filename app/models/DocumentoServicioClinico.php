<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentoServicioClinico extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'documentos_servicios_clinicos';

	public function servicio()
	{
		return $this->belongsTo('Servicio','id_servicio');
	}

	public function usuario()
	{
		return $this->belongsTo('User','id_usuario');
	}

	public function scopeSearchDocumentos($query,$search_codigo,$search_servicio,$search_usuario,$search_nombre)
	{
		$query->withTrashed();
			  
		if($search_codigo != "")
		{
			$query->where('documentos_servicios_clinicos.codigo','LIKE',"%$search_codigo%");
		}

		if($search_servicio != 0)
		{
			$query->where('documentos_servicios_clinicos.id_servicio','=', $search_servicio);
		}

		if($search_usuario != 0)
		{
			$query->where('documentos_servicios_clinicos.id_usuario','=',$search_usuario);
		}

		if($search_nombre != "")
		{
			$query->where('documentos_servicios_clinicos.nombre','LIKE',"%$search_nombre%");
		}
			  
		return $query;
	}
}