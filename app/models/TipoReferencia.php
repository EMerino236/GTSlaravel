<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoReferencia extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_referencia';
	protected $primaryKey = 'idtipo_referencia';

}