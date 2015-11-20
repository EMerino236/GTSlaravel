<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoOtBusquedaInformacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_busqueda_infos';
	protected $primaryKey = 'idtipo_busqueda_info';

	
}