<?php

class ProgramacionDocenteController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){
				
				$data["search_nombre"] = null;
				$data["search_servicio_clinico"] = null;
				$data["search_departamento"] = null;
				$data["search_responsable"] = null;
				$data["search_fecha_ini"] = null;
				$data["search_fecha_fin"] = null;

				$data["nombres"] = Perfil::where('id_rol',0)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				
				$data["reportes_data"] = ProgramacionInternado::withTrashed()->paginate(10);
				
				return View::make('rrhh.programacion_docente.index',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)
			{
				$data["nombres"] = Perfil::where('id_rol',0)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				
				$ini = 	Carbon\Carbon::now()->startOfMonth();
				$end =	Carbon\Carbon::now()->startOfMonth()->addMonth();
				
				while($ini->month != $end->month){
					$dia = $ini->format('Y-m-d');
					//Deberia ser sesiones del mes
					$temp = ProgramacionInternado::where('fecha_ini','<=',$dia)->where('fecha_fin','>=',$dia)->get();

					if(!$temp->isEmpty()){
						foreach ($temp as $var) {
							$dayEvents[$var->id] = $var;
						}
						$dias[$dia] = ["number" => $temp->count(), "badgeClass" => "badge-warning", "dayEvents" => $dayEvents];	
					}else{
						$dias[$dia] = null;
					}
					
					$ini = $ini->addDay();
				}
				$dias = json_encode($dias);
				$data["dias"] = $dias;

				return View::make('rrhh.programacion_docente.create',$data);
			}
			else
			{
				return View::make('error/error',$data);
			}
		}
		else
		{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
