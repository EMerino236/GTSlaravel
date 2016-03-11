<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoObservacionExpediente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_observacion_expediente';
	protected $primaryKey = 'idtipo_observacion_expediente';

}