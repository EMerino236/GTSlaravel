<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Rol extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'roles';
}