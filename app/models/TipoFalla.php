<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoFalla extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $primaryKey = 'idtipo_falla';
}