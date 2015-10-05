<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SolicitudCompra extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table ="solicitud_compras";
	protected $primaryKey = "idsolicitud_compra";

}