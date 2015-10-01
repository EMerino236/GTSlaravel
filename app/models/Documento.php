<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Documento extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $primaryKey = 'iddocumento';
	protected $table = 'documentos';	

	public function scopeGetDocumentosInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_documentos','tipo_documentos.idtipo_documento','=','documentos.idtipo_documento')
			  ->select('tipo_documentos.nombre as tipo_documento','documentos.*');
		return $query;
	}

	public function scopeSearchDocumentoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('iddocumento','=',$search_criteria);
		return $query;
	}	

	public function scopeSearchDocumentos($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('nombre','LIKE',"%$search_criteria%")
			  ->select('nombre','descripcion');
		return $query;
	}	
}