<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Prioridad extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'prioridades';
	protected $primaryKey = 'idprioridad';

}