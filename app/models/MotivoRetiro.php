<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class MotivoRetiro extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idmotivo_retiro';

}