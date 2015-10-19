<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Componente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'componentes';
	protected $primaryKey = 'idcomponente';

}