<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoEspecificacionTecnica extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_especificacion_tecnica';
	protected $primaryKey = 'idtipo_especificacion_tecnica';

}