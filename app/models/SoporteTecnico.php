<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SoporteTecnico extends Eloquent {
	
	use SoftDeletingTrait;
	protected $softDelete = true;

	protected $table = 'soporte_tecnicos';
	protected $primaryKey = 'idsoporte_tecnico';

	public function scopeGetSoportesTecnicoInfo($query)
	{
		$query->join('tipo_doc_identidades','tipo_doc_identidades.idtipo_documento','=','soporte_tecnicos.idtipo_documento')
			  ->join('proveedores','proveedores.idproveedor','=','soporte_tecnicos.idproveedor')
	 		  ->select('tipo_doc_identidades.nombre as tipo_documento','proveedores.razon_social as proveedor','soporte_tecnicos.*');

	    return $query;
	}

	public function scopeSearchSoporteTecnico($query,$search_proveedor,$search_tipo_documento, $search_numero_documento, $search_nombre, $search_apPaterno, $search_apMaterno)
	{
		$query->join('tipo_doc_identidades','tipo_doc_identidades.idtipo_documento','=','soporte_tecnicos.idtipo_documento')
			  ->join('proveedores','proveedores.idproveedor','=','soporte_tecnicos.idproveedor');

	  	if($search_proveedor != '')
	  	{
	  		$query->where('soporte_tecnicos.idproveedor','=',$search_proveedor);
	  	}

		if($search_tipo_documento !='' && $search_numero_documento != "")
		{						
			$query->where('soporte_tecnicos.idtipo_documento','=',$search_tipo_documento)
				  ->where('soporte_tecnicos.numero_doc_identidad','=',$search_numero_documento);
		}

		if($search_nombre != "")
		{
			$query->where('soporte_tecnicos.idtipo_documento','LIKE','%$search_nombre%');
		}

		if($search_apPaterno != "")
		{
			$query->where('soporte_tecnicos.idtipo_documento','LIKE','%$search_apPaterno%');
		}

		if($search_apMaterno != "")
		{
			$query->where('soporte_tecnicos.idtipo_documento','LIKE','%$search_apMaterno%');
		}

		$query->select('tipo_doc_identidades.nombre as tipo_documento','soporte_tecnicos.*');

		return $query;
	}

	public function scopeSearchSoporteTecnicoByNumeroDocumento($query,$idtipo_documento,$numero_doc_identidad)
	{
		$query->join('proveedores','proveedores.idproveedor','=','soporte_tecnicos.idproveedor')
			  ->where('soporte_tecnicos.idtipo_documento','=',$idtipo_documento)
			  ->where('soporte_tecnicos.numero_doc_identidad','=',$numero_doc_identidad);
		
		$query->select('proveedores.razon_social as proveedor','soporte_tecnicos.*');
	}

}