<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoCompraExpediente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_compra_expediente';
	protected $primaryKey = 'idtipo_compra_expediente';

}