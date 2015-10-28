<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoActa extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_actas';
	protected $primaryKey = 'idtipo_acta';

	
}