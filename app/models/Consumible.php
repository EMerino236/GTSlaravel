<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Consumible extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'consumibles';
	protected $primaryKey = 'idconsumible';
}