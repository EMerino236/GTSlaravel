<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoActivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_activos';
	protected $primaryKey = 'idtipo_activo';
}