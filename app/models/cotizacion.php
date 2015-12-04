<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Cotizacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'cotizaciones';
	protected $primaryKey = 'idcotizacion';

	public function scopeGetCotizacionInfo($query)
	{	
		$query->select('cotizaciones.*');
		return $query;
	}

	public function scopeSearchCotizacionInfo($query,$search_nombre_equipo,$search_nombre_detallado,$search_marca,$search_modelo)
	{	
		if($search_nombre_equipo != "")
		{
			$query->where('nombre_equipo','LIKE',"%$search_nombre_equipo%");
		}	
		if($search_nombre_detallado != "")
		{
			$query->where('nombre_detallado','LIKE',"%$search_nombre_detallado%");
		}	
		if($search_marca != "")
		{
			$query->where('marca','LIKE',"%$search_marca%");
		}
		if($search_modelo != "")
		{
			$query->where('modelo','LIKE',"%$search_modelo%");
		}
		return $query;
	}

	public function scopeGetCotizacionesHistorico($query,$nombre_equipo,$nombre_detallado,$anho1,$anho2,$anho3,$anho4,$anho5,$anho6)
	{	
		$sql = 'select distinct c.codigo_cotizacion,c.marca,c.modelo_equipo,c.proveedor,if(c.enlace_seace is null,\'-\',c.enlace_seace) as enlace_seace,a.nombre_detallado, a.precio as precio1,
				b.precio as precio2,d.precio as precio3,e.precio as precio4,f.precio as precio5,g.precio as precio6
				from cotizaciones c 
     				 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=1 and a.anho='.$anho1.') a
								on a.nombre_equipo = c.nombre_equipo and a.nombre_detallado = c.nombre_detallado 
								and a.marca = c.marca and a.modelo_equipo = c.modelo_equipo and a.proveedor = c.proveedor
					 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=1 and a.anho='.$anho2.') b
								on b.nombre_equipo = c.nombre_equipo and b.nombre_detallado = c.nombre_detallado 
								and b.marca = c.marca and b.modelo_equipo = c.modelo_equipo and b.proveedor = c.proveedor
					 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=1 and a.anho='.$anho3.') d
								on d.nombre_equipo = c.nombre_equipo and d.nombre_detallado = c.nombre_detallado 
								and d.marca = c.marca and d.modelo_equipo = c.modelo_equipo and d.proveedor = c.proveedor
					 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=1 and a.anho='.$anho4.') e
								on e.nombre_equipo = c.nombre_equipo and e.nombre_detallado = c.nombre_detallado 
								and e.marca = c.marca and e.modelo_equipo = c.modelo_equipo and e.proveedor = c.proveedor
					 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=1 and a.anho='.$anho5.') f
								on f.nombre_equipo = c.nombre_equipo and f.nombre_detallado = c.nombre_detallado 
								and f.marca = c.marca and f.modelo_equipo = c.modelo_equipo and f.proveedor = c.proveedor
					left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=1 and a.anho='.$anho6.') g
								on g.nombre_equipo = c.nombre_equipo and g.nombre_detallado = c.nombre_detallado 
								and g.marca = c.marca and g.modelo_equipo = c.modelo_equipo and g.proveedor = c.proveedor
					 where c.idtipo_referencia=1 and c.nombre_equipo = \''.$nombre_equipo.'\' and c.nombre_detallado = \''.$nombre_detallado.'\'';
		$query = DB::select(DB::raw($sql));
		return $query;
	}

	public function scopeGetReferenciasSeaceHistorico($query,$nombre_equipo,$nombre_detallado,$anho1,$anho2,$anho3,$anho4,$anho5,$anho6)
	{	
		$sql = 'select distinct c.codigo_cotizacion,c.marca,c.modelo_equipo,c.proveedor,if(c.enlace_seace is null,\'-\',c.enlace_seace) as enlace_seace,a.nombre_detallado, a.precio as precio1,
				b.precio as precio2,d.precio as precio3,e.precio as precio4,f.precio as precio5,g.precio as precio6
				from cotizaciones c 
     				 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=2 and a.anho='.$anho1.') a
								on a.nombre_equipo = c.nombre_equipo and a.nombre_detallado = c.nombre_detallado 
								and a.marca = c.marca and a.modelo_equipo = c.modelo_equipo and a.proveedor = c.proveedor
					 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=2 and a.anho='.$anho2.') b
								on b.nombre_equipo = c.nombre_equipo and b.nombre_detallado = c.nombre_detallado 
								and b.marca = c.marca and b.modelo_equipo = c.modelo_equipo and b.proveedor = c.proveedor
					 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=2 and a.anho='.$anho3.') d
								on d.nombre_equipo = c.nombre_equipo and d.nombre_detallado = c.nombre_detallado 
								and d.marca = c.marca and d.modelo_equipo = c.modelo_equipo and d.proveedor = c.proveedor
					 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=2 and a.anho='.$anho4.') e
								on e.nombre_equipo = c.nombre_equipo and e.nombre_detallado = c.nombre_detallado 
								and e.marca = c.marca and e.modelo_equipo = c.modelo_equipo and e.proveedor = c.proveedor
					 left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=2 and a.anho='.$anho5.') f
								on f.nombre_equipo = c.nombre_equipo and f.nombre_detallado = c.nombre_detallado 
								and f.marca = c.marca and f.modelo_equipo = c.modelo_equipo and f.proveedor = c.proveedor
					left join (select a.nombre_equipo, a.nombre_detallado, a.marca, a.modelo_equipo, a.proveedor, a.precio
								from cotizaciones a
								where a.idtipo_referencia=2 and a.anho='.$anho6.') g
								on g.nombre_equipo = c.nombre_equipo and g.nombre_detallado = c.nombre_detallado 
								and g.marca = c.marca and g.modelo_equipo = c.modelo_equipo and g.proveedor = c.proveedor
					 where c.idtipo_referencia=2 and c.nombre_equipo = \''.$nombre_equipo.'\' and c.nombre_detallado = \''.$nombre_detallado.'\'';
		$query = DB::select(DB::raw($sql));
		return $query;
	}
}