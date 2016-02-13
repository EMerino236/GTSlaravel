<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Proceso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'procesos';

	
}