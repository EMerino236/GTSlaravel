<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Presupuesto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'presupuestos';

	public function categoria()
	{
		return $this->belongsTo('ProyectoCategoria', 'id_categoria');
	}

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

	public function proyecto()
	{
		return $this->belongsTo('Proyecto', 'id_proyecto');
	}	

	public function actividadesrh()
	{
		return $this->hasMany('PresupuestoActividad','id_presupuesto')->where('id_clase',0)->where('id_tipo',0);
	}

	public function actividadesrhpost()
	{
		return $this->hasMany('PresupuestoActividad','id_presupuesto')->where('id_clase',0)->where('id_tipo',1);
	}

	public function actividadeseq()
	{
		return $this->hasMany('PresupuestoActividad','id_presupuesto')->where('id_clase',1)->where('id_tipo',0);
	}

	public function actividadeseqpost()
	{
		return $this->hasMany('PresupuestoActividad','id_presupuesto')->where('id_clase',1)->where('id_tipo',1);
	}

	public function actividadesgo()
	{
		return $this->hasMany('PresupuestoActividad','id_presupuesto')->where('id_clase',2)->where('id_tipo',0);
	}

	public function actividadesgopost()
	{
		return $this->hasMany('PresupuestoActividad','id_presupuesto')->where('id_clase',2)->where('id_tipo',1);
	}

	public function actividadesga()
	{
		return $this->hasMany('PresupuestoActividad','id_presupuesto')->where('id_clase',3)->where('id_tipo',0);
	}

	public function actividadesgapost()
	{
		return $this->hasMany('PresupuestoActividad','id_presupuesto')->where('id_clase',3)->where('id_tipo',1);
	}

}