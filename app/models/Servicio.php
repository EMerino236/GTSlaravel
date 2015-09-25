<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Servicio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'servicios';


}