<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PresupuestoCapacitacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'presupuestos_capacitacion';

	public function servicio()
	{
		return $this->belongsTo('Servicio', 'id_servicio_clinico');
	}

	public function departamento()
	{
		return $this->belongsTo('Area', 'id_departamento');
	}

	public function responsable()
	{
		return $this->belongsTo('User', 'id_responsable');
	}

	public function tipo()
	{
		return $this->belongsTo('RHTipo', 'id_tipo');	
	}

	public function modalidad()
	{
		return $this->belongsTo('RHModalidad', 'id_modalidad');	
	}

	public function capacitacion()
	{
		return $this->belongsTo('Capacitacion', 'id_capacitacion');	
	}

	public function actividadesrh()
	{
		return $this->hasMany('PresupuestoCapacitacionActividad','id_presupuesto_capacitacion')->where('id_clase',0);
	}

	public function actividadeseq()
	{
		return $this->hasMany('PresupuestoCapacitacionActividad','id_presupuesto_capacitacion')->where('id_clase',1);
	}

	public function actividadesgo()
	{
		return $this->hasMany('PresupuestoCapacitacionActividad','id_presupuesto_capacitacion')->where('id_clase',2);
	}

	public function actividadesga()
	{
		return $this->hasMany('PresupuestoCapacitacionActividad','id_presupuesto_capacitacion')->where('id_clase',3);
	}

}