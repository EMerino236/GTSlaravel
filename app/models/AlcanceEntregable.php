<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AlcanceEntregable extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'alcances_entregables';

}