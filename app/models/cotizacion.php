<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Cotizacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'cotizaciones';
	protected $primaryKey = 'idcotizacion';

}