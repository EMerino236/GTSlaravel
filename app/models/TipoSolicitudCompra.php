<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoSolicitudCompra extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = "tipo_solicitud_compras";
	protected $primaryKey = 'idtipo_solicitud_compra';

}