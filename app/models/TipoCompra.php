<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoCompra extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_compra';
	protected $primaryKey = 'idtipo_compra';

}