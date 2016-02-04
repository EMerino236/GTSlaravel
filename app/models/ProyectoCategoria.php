<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProyectoCategoria extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyecto_categorias';
	protected $primaryKey = 'id';

}