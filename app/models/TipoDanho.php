<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoDanho extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_danho';
}