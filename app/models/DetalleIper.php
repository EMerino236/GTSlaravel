<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetalleIper extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'detalle_iper';

	public function scopeGetDetallesByIdIper($query,$idiper){
		$query->withTrashed()
			  ->join('ipers','ipers.id','=','detalle_iper.idiper')
			  ->where('detalle_iper.idiper','=',$idiper)
			  ->select('detalle_iper.*');
	}

	public function scopeGetLastDetalle($query,$idiper){
		$query->withTrashed()
			  ->join('ipers','ipers.id','=','detalle_iper.idiper')
			  ->where('detalle_iper.idiper','=',$idiper)
			  ->orderBy('detalle_iper.id','desc');
	}
}