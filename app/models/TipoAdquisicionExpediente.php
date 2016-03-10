<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoAdquisicionExpediente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_adquisicion_expediente';
	protected $primaryKey = 'idtipo_adquisicion_expediente';

}