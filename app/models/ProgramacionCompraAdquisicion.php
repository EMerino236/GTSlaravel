<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProgramacionCompraAdquisicion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'programacion_compra_adquisicion';
	protected $primaryKey = 'idprogramacion_compra';

}