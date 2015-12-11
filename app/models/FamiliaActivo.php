<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class FamiliaActivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'familia_activos';
	protected $primaryKey = 'idfamilia_activo';

	public function tipoActivo()
	{
		return $this->belongsTo('TipoActivo','idtipo_activo');
	}

	public function marca()
	{
		return $this->belongsTo('Marca','idmarca');
	}

	public function scopeGetFamiliaActivosInfo($query)
	{
		$query->withTrashed()
			  ->select('familia_activos.*');
	    return $query;
	}

	public function scopeSearchFamiliaActivo($query,$search_nombre_equipo,$search_marca)
	{
		$query->where('familia_activos.nombre_equipo','LIKE',"%$search_nombre_equipo%");
			  

		if($search_marca != "")
		{
			$query->where('familia_activos.idmarca','=',$search_marca);
		}

	 	$query->select('familia_activos.*');
	 	
		return $query;
	}

	public function scopeSearchFamiliaActivoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('familia_activos.idfamilia_activo',"=",$search_criteria);
		return $query;
	}

	public function scopeSearchFamiliaActivoByMarca($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('familia_activos.idmarca','=',$search_criteria);
	}

	/*
	public function scopeGetFamiliaActivosCotizacionesInfo($query)
	{
		$componentes = DB::table('familia_activos')->join('modelo_activos','modelo_activos.idfamilia_activo','=','familia_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->leftjoin('componentes','componentes.idmodelo_equipo','=','modelo_activos.idmodelo_equipo')
			  ->select('modelo_activos.nombre as modelo','marcas.nombre as marca',
			  	DB::raw('(CASE WHEN componentes.nombre is null THEN \'-\' ELSE componentes.nombre END) AS nombre_detallado')
			  	,'familia_activos.*');
		$consumibles = DB::table('familia_activos')->join('modelo_activos','modelo_activos.idfamilia_activo','=','familia_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('consumibles','consumibles.idmodelo_equipo','=','modelo_activos.idmodelo_equipo')
			  ->select('modelo_activos.nombre as modelo','marcas.nombre as marca','consumibles.nombre as nombre_detallado','familia_activos.*');
		$accesorios = DB::table('familia_activos')->join('modelo_activos','modelo_activos.idfamilia_activo','=','familia_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('accesorios','accesorios.idmodelo_equipo','=','modelo_activos.idmodelo_equipo')
			  ->select('modelo_activos.nombre as modelo','marcas.nombre as marca','accesorios.nombre as nombre_detallado','familia_activos.*');
		$query = $accesorios
			  ->union($componentes)		  
			  ->union($consumibles)
			  ->orderBy('nombre_equipo')
			  ->orderBy('nombre_detallado');
		return $query;
			  /*
		$sql = '(select t.nombre as modelo, m.nombre as marca, c.nombre as nombre_detallado, f.*
				from familia_activos f
				     join modelo_activos t on t.idfamilia_activo = f.idfamilia_activo
				     join marcas m on m.idmarca = f.idmarca
				     left join componentes c on c.idmodelo_equipo = t.idmodelo_equipo)
				union
				(select t.nombre as modelo, m.nombre as marca, c.nombre as nombre_detallado, f.*
				from familia_activos f
				     join modelo_activos t on t.idfamilia_activo = f.idfamilia_activo
				     join marcas m on m.idmarca = f.idmarca
				     join consumibles c on c.idmodelo_equipo = t.idmodelo_equipo)
				union
				(select t.nombre as modelo, m.nombre as marca, c.nombre as nombre_detallado, f.*
				from familia_activos f
				     join modelo_activos t on t.idfamilia_activo = f.idfamilia_activo
				     join marcas m on m.idmarca = f.idmarca
				     join accesorios c on c.idmodelo_equipo = t.idmodelo_equipo)';
		$query = DB::select(DB::raw($sql));
		return $query;
		*/
	//}
/*
	public function scopeSearchFamiliaActivosCotizacionesInfo($query,$search_nombre_equipo,$search_nombre_detallado,$search_marca,$search_modelo)
	{
		$componentes = DB::table('familia_activos')->join('modelo_activos','modelo_activos.idfamilia_activo','=','familia_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->leftjoin('componentes','componentes.idmodelo_equipo','=','modelo_activos.idmodelo_equipo');
			  if($search_nombre_equipo != "")
			  {
			  	$componentes->where('familia_activos.nombre_equipo','LIKE',"%$search_nombre_equipo%");
			  }
			  if($search_nombre_detallado != "")
			  {
			  	$componentes->where('componentes.nombre','LIKE',"%$search_nombre_detallado%");
			  }
			  if($search_marca != "")
			  {
			  	$componentes->where('marcas.nombre','LIKE',"%$search_marca%");
			  }
			  if($search_modelo != "")
			  {
			  	$componentes->where('modelo_activos.nombre','LIKE',"%$search_modelo%");
			  }
		$componentes->select('modelo_activos.nombre as modelo','marcas.nombre as marca',
			DB::raw('(CASE WHEN componentes.nombre is null THEN \'-\' ELSE componentes.nombre END) AS nombre_detallado')
			,'familia_activos.*');
		$consumibles = DB::table('familia_activos')->join('modelo_activos','modelo_activos.idfamilia_activo','=','familia_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('consumibles','consumibles.idmodelo_equipo','=','modelo_activos.idmodelo_equipo');
			  if($search_nombre_equipo != "")
			  {
			  	$consumibles->where('familia_activos.nombre_equipo','LIKE',"%$search_nombre_equipo%");
			  }
			  if($search_nombre_detallado != "")
			  {
			  	$consumibles->where('consumibles.nombre','LIKE',"%$search_nombre_detallado%");
			  }
			  if($search_marca != "")
			  {
			  	$consumibles->where('marcas.nombre','LIKE',"%$search_marca%");
			  }
			  if($search_modelo != "")
			  {
			  	$consumibles->where('modelo_activos.nombre','LIKE',"%$search_modelo%");
			  }
		$consumibles->select('modelo_activos.nombre as modelo','marcas.nombre as marca','consumibles.nombre as nombre_detallado','familia_activos.*');
		$accesorios = DB::table('familia_activos')->join('modelo_activos','modelo_activos.idfamilia_activo','=','familia_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('accesorios','accesorios.idmodelo_equipo','=','modelo_activos.idmodelo_equipo');
			  if($search_nombre_equipo != "")
			  {
			  	$accesorios->where('familia_activos.nombre_equipo','LIKE',"%$search_nombre_equipo%");
			  }
			  if($search_nombre_detallado != "")
			  {
			  	$accesorios->where('accesorios.nombre','LIKE',"%$search_nombre_detallado%");
			  }
			  if($search_marca != "")
			  {
			  	$accesorios->where('marcas.nombre','LIKE',"%$search_marca%");
			  }
			  if($search_modelo != "")
			  {
			  	$accesorios->where('modelo_activos.nombre','LIKE',"%$search_modelo%");
			  }
		$accesorios->select('modelo_activos.nombre as modelo','marcas.nombre as marca','accesorios.nombre as nombre_detallado','familia_activos.*');
		$query = $accesorios
			  ->union($componentes)		  
			  ->union($consumibles)
			  ->orderBy('nombre_equipo')
			  ->orderBy('nombre_detallado');
		return $query;
	}
*/
	public function scopeGetActivosPrecioHistorico($query,$nombre_equipo,$anho1,$anho2,$anho3,$anho4,$anho5,$anho6)
	{	
		$sql = 'select distinct a.codigo_compra, m.nombre as modelo_equipo ,p.razon_social as proveedor, c.nombre as marca, \'-\' as enlace_seace,
					b.costo as precio1, c.costo as precio2, d.costo as precio3, e.costo as precio4, f.costo as precio5,
					g.costo as precio6
				from activos a 
					join proveedores p on a.idproveedor = p.idproveedor
					join modelo_activos m on a.idmodelo_equipo = m.idmodelo_equipo
					join familia_activos f on m.idfamilia_activo = f.idfamilia_activo
					join marcas c on f.idmarca = c.idmarca
					left join (select t.codigo_compra, t.idproveedor, t.idmodelo_equipo, t.costo
						   from activos t
						   where YEAR(t.anho_adquisicion)='.$anho1.') b
						   on a.codigo_compra = b.codigo_compra and b.idproveedor = a.idproveedor and b.idmodelo_equipo = a.idmodelo_equipo
					left join (select t.codigo_compra, t.idproveedor, t.idmodelo_equipo, t.costo
						   from activos t
						   where YEAR(t.anho_adquisicion)='.$anho2.') c
						   on a.codigo_compra = c.codigo_compra and c.idproveedor = a.idproveedor and c.idmodelo_equipo = a.idmodelo_equipo
					left join (select t.codigo_compra, t.idproveedor, t.idmodelo_equipo, t.costo
						   from activos t
						   where YEAR(t.anho_adquisicion)='.$anho3.') d
						   on a.codigo_compra = d.codigo_compra and d.idproveedor = a.idproveedor and d.idmodelo_equipo = a.idmodelo_equipo
					left join (select t.codigo_compra, t.idproveedor, t.idmodelo_equipo, t.costo
						   from activos t
						   where YEAR(t.anho_adquisicion)='.$anho4.') e
						   on a.codigo_compra = e.codigo_compra and e.idproveedor = a.idproveedor and e.idmodelo_equipo = a.idmodelo_equipo
					left join (select t.codigo_compra, t.idproveedor, t.idmodelo_equipo, t.costo
						   from activos t
						   where YEAR(t.anho_adquisicion)='.$anho5.') f
						   on a.codigo_compra = f.codigo_compra and f.idproveedor = a.idproveedor and f.idmodelo_equipo = a.idmodelo_equipo
					left join (select t.codigo_compra, t.idproveedor, t.idmodelo_equipo, t.costo
						   from activos t
						   where YEAR(t.anho_adquisicion)='.$anho6.') g
						   on a.codigo_compra = g.codigo_compra and g.idproveedor = a.idproveedor and g.idmodelo_equipo = a.idmodelo_equipo
				where f.nombre_equipo = \''.$nombre_equipo.'\'';
		$query = DB::select(DB::raw($sql));
		return $query;
	}

	public function tipo(){
		return $this->belongsTo('TipoActivo','idtipo_activo');
	}

	public function estado(){
		return $this->belongsTo('Estado','idestado');
	}

}