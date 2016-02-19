<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AlcanceExclusion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'alcances_exclusiones';

}