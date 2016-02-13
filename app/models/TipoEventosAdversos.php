<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoEventosAdversos extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $primaryKey = 'idtipo_incidente';
	protected $table = 'tipo_incidente';
	
	
}