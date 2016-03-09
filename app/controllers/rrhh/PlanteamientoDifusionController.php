<?php

class PlanteamientoDifusionController extends BaseController
{	

	public function index()
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)
			{
				$data["search_nombre_plan_difusion"] = null;
				$data["search_responsable_plan_difusion"]=null;
				$data["search_departamento_plan_difusion"]=null;
				$data["search_servicio_plan_difusion"]=null;
				$data["fecha_ini_plan_difusion"]=null;
				$data["fecha_fin_plan_difusion"]=null;
				$data["row_number"] = 10;

				$data["departamentos"] = Area::lists('nombre','idarea');				

				$data["planes_difusion"] = PlanDifusion::paginate($data["row_number"]);


				return View::make('rrhh/planteamiento_difusion/index',$data);
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

	public function search()
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)
			{
				$data["departamentos"] = Area::lists('nombre','idarea');				
				
				$data["search_nombre_plan_difusion"] = Input::get('search_nombre_plan_difusion');
				$data["search_departamento_plan_difusion"] = Input::get('search_departamento_plan_difusion');
				$data["search_servicio_plan_difusion"] = Input::get('search_servicio_plan_difusion');				
				$data["search_responsable_plan_difusion"] = Input::get('search_responsable_plan_difusion');					
				$data["fecha_ini_plan_difusion"] = Input::get('fecha_ini_plan_difusion');
				$data["fecha_fin_plan_difusion"] = Input::get('fecha_fin_plan_difusion');

				$data["row_number"] = Input::get('row_number');


				$data["planes_difusion"] = PlanDifusion::searchPlanDifusion($data["search_nombre_plan_difusion"],$data["search_departamento_plan_difusion"],$data["search_servicio_plan_difusion"],
																			$data["search_responsable_plan_difusion"],$data["fecha_ini_plan_difusion"],$data["fecha_fin_plan_difusion"])->paginate($data["row_number"]);


				return View::make('rrhh/planteamiento_difusion/index',$data);
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

	public function create()
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)
			{
				$data["departamentos"] = Area::lists('nombre','idarea');				

				return View::make('rrhh/planteamiento_difusion/create',$data);
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

	public function store()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$attributes=array(
					'nombre_planteamiento_difusion' => 'Nombre del Documento',
					'departamento_planteamiento_difusion' => 'Departamento',
					'servicio_planteamiento_difusion' => 'Servicio',
					'descripcion_planteamiento_difusion' => 'Descripción del Documento',
					'dni_responsable_planteamiento_difusion' => 'Responsable Asignado',
					'fecha_ini_planteamiento_difusion' => 'Fecha Inicio',
					'fecha_fin_planteamiento_difusion' => 'Fehca Fin',
					'archivo' => 'Plan de Difusión'
					);

				$messages=array(
					);

				$rules = array(
					'nombre_planteamiento_difusion' => 'required|max:200',
					'departamento_planteamiento_difusion' => 'required',
					'servicio_planteamiento_difusion' => 'required',
					'descripcion_planteamiento_difusion' => 'required|max:200',
					'dni_responsable_planteamiento_difusion' => 'required',
					'idresponsable' => 'required',
					'fecha_ini_planteamiento_difusion' => 'required',
					'fecha_fin_planteamiento_difusion' => 'required',
					'archivo' => 'required'				
					);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to('planteamiento_difusion/create')->withErrors($validator)->withInput(Input::all());
				}else{

					$plan_difusion = new PlanDifusion;
					$plan_difusion->nombre = Input::get('nombre_planteamiento_difusion');
					$plan_difusion->iddepartamento = Input::get('departamento_planteamiento_difusion');
					$plan_difusion->idservicio = Input::get('servicio_planteamiento_difusion');
					$plan_difusion->descripcion = Input::get('descripcion_planteamiento_difusion');
					$plan_difusion->idresponsable = Input::get('idresponsable');					
					$plan_difusion->fechainicio = date('Y-m-d',strtotime(Input::get('fecha_ini_planteamiento_difusion')));
					$plan_difusion->fechafin = date('Y-m-d',strtotime(Input::get('fecha_fin_planteamiento_difusion')));

					if(Input::hasFile('archivo'))
					{
						$archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/RRHH/Plan de Difusion/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);						
						
						$plan_difusion->nombre_archivo = $nombreArchivo;
						$plan_difusion->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$plan_difusion->url = $rutaDestino;
					}

					$plan_difusion->save();
					
					return Redirect::to('planteamiento_difusion/index')->with('message', 'Se registró correctamente el plan de difusión.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function show($id)
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 && $id)
			{
				$data["plan_difusion"] = PlanDifusion::find($id);

				if($data["plan_difusion"] == null)
					return Redirect::to('planteamiento_difusion/index');

				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');

				return View::make('rrhh/planteamiento_difusion/show',$data);
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
		
	public function edit($id)
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 && $id)
			{
				$data["plan_difusion"] = PlanDifusion::find($id);

				if($data["plan_difusion"] == null)
					return Redirect::to('planteamiento_difusion/index');

				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');

				return View::make('rrhh/planteamiento_difusion/edit',$data);
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

	public function update($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$attributes=array(
					'nombre_planteamiento_difusion' => 'Nombre del Documento',
					'departamento_planteamiento_difusion' => 'Departamento',
					'servicio_planteamiento_difusion' => 'Servicio',
					'descripcion_planteamiento_difusion' => 'Descripción del Documento',
					'dni_responsable_planteamiento_difusion' => 'Responsable Asignado',
					'fecha_ini_planteamiento_difusion' => 'Fecha Inicio',
					'fecha_fin_planteamiento_difusion' => 'Fehca Fin',
					'archivo' => 'Plan de Difusión'
					);

				$messages=array(
					);

				$rules = array(
					'nombre_planteamiento_difusion' => 'required|max:200',
					'departamento_planteamiento_difusion' => 'required',
					'servicio_planteamiento_difusion' => 'required',
					'descripcion_planteamiento_difusion' => 'required|max:200',
					'dni_responsable_planteamiento_difusion' => 'required',
					'idresponsable' => 'required',
					'fecha_ini_planteamiento_difusion' => 'required',
					'fecha_fin_planteamiento_difusion' => 'required',
					'archivo' => ''				
					);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to('planteamiento_difusion/edit')->withErrors($validator)->withInput(Input::all());
				}else{

					$plan_difusion = PlanDifusion::find($id);

					if($plan_difusion == null)
						return Redirect::to('planteamiento_difusion/index');
					
					$plan_difusion->nombre = Input::get('nombre_planteamiento_difusion');
					$plan_difusion->iddepartamento = Input::get('departamento_planteamiento_difusion');
					$plan_difusion->idservicio = Input::get('servicio_planteamiento_difusion');
					$plan_difusion->descripcion = Input::get('descripcion_planteamiento_difusion');
					$plan_difusion->idresponsable = Input::get('idresponsable');					
					$plan_difusion->fechainicio = date('Y-m-d',strtotime(Input::get('fecha_ini_planteamiento_difusion')));
					$plan_difusion->fechafin = date('Y-m-d',strtotime(Input::get('fecha_fin_planteamiento_difusion')));

					if(Input::hasFile('archivo'))
					{
						$archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/RRHH/Plan de Difusion/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);						
						
						$plan_difusion->nombre_archivo = $nombreArchivo;
						$plan_difusion->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$plan_difusion->url = $rutaDestino;
					}

					$plan_difusion->save();
					
					return Redirect::to('planteamiento_difusion/index')->with('message', 'Se actualizó correctamente el plan de difusión.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function destroy()
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2)
			{
				$id = Input::get("id_plan_difusion");

				$plan_difusion = PlanDifusion::find($id);
				

				if($plan_difusion != null)
				{
					$plan_difusion->delete();
					return Redirect::to('planteamiento_difusion/index');
				}
					

				return Redirect::to('planteamiento_difusion/index');
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

	public function download($id)
	{
		if(Auth::check()){

			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12 && $id )
			{
				$data["plan_difusion"] = PlanDifusion::find($id);

				if($data["plan_difusion"] == null)
					return Redirect::to('plan_difusion/index');

				$rutaDestino = $data["plan_difusion"]->url.$data["plan_difusion"]->nombre_archivo_encriptado;

		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );

		        return Response::download($rutaDestino,basename($data["plan_difusion"]->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function getServiciosAjax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();

		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');

		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)
		{			
			$data = Input::get('value');

			if($data != "")
			{
				$servicios = Servicio::where('idarea','=',$data)->get();
			}
			else
			{
				$servicios = array();
			}

			return Response::json(array( 'success' => true, 'servicios' => $servicios ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function getUserAjax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();

		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');

		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)
		{			
			$data = Input::get('value');

			if($data != "")
			{
				$user = User::where('numero_doc_identidad','=',$data)->get();
			}
			else
			{
				$user = array();
			}

			return Response::json(array( 'success' => true, 'user' => $user ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}