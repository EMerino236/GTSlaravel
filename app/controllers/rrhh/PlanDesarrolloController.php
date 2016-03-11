<?php

class PlanDesarrolloController extends BaseController
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
				$data["search_codigo_documento"] = null;
				$data["search_nombre_documento"] = null;
				$data["search_autor_documento"] = null;				
				$data["row_number"] = 10;

				$data["planes_desarrollo"] = PlanDesarrollo::paginate($data["row_number"]);				

				return View::make('rrhh/planes_desarrollo/index',$data);
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
		if(Auth::check()){

			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');

			
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)
			{
				$data["search_codigo_documento"] = Input::get('search_codigo_documento');
				$data["search_nombre_documento"] = Input::get('search_nombre_documento');
				$data["search_autor_documento"] = Input::get('search_autor_documento');
				
				$data["row_number"] = Input::get('row_number');			

				$data["planes_desarrollo"] = PlanDesarrollo::searchPlanDesarrollo($data["search_codigo_documento"],$data["search_nombre_documento"],$data["search_autor_documento"])->paginate($data["row_number"]);

				return View::make('rrhh/planes_desarrollo/index',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
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
				return View::make('rrhh/planes_desarrollo/create',$data);
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
					'nombre_documento' => 'Nombre del Documento',
					'autor_documento' => 'Nombre del Autor',
					'codigo_documento' => 'Código de Archivamiento',
					'descripcion_documento' => 'Descripción del Documento',					
					'archivo' => 'Plan de Desarrollo de RRHH'
					);

				$messages=array(
					);

				$rules = array(
					'nombre_documento' => 'required|max:200',
					'autor_documento' => 'required|max:200',
					'codigo_documento' => 'required|max:100',
					'descripcion_documento' => 'required|max:200',					
					'archivo' => 'required'				
					);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to('plan_desarrollo/create')->withErrors($validator)->withInput(Input::all());
				}else{

					$plan_desarrollo = new PlanDesarrollo;
					$plan_desarrollo->nombre = Input::get('nombre_documento');
					$plan_desarrollo->autor = Input::get('autor_documento');
					$plan_desarrollo->descripcion = Input::get('descripcion_documento');
					$plan_desarrollo->codigo_archivamiento = Input::get('codigo_documento');					

					if(Input::hasFile('archivo'))
					{
						$archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/RRHH/Plan de Desarrollo/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);						
						
						$plan_desarrollo->nombre_archivo = $nombreArchivo;
						$plan_desarrollo->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$plan_desarrollo->url = $rutaDestino;
					}

					$plan_desarrollo->save();
					
					return Redirect::to('plan_desarrollo/index')->with('message', 'Se registró correctamente el plan de desarrollo de rrhh.');
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
				$data["plan_desarrollo"] = PLanDesarrollo::find($id);

				if($data["plan_desarrollo"] == null)
					return Redirect::to('plan_desarrollo/index');

				return View::make('rrhh/planes_desarrollo/show',$data);
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
				$data["plan_desarrollo"] = PLanDesarrollo::find($id);

				if($data["plan_desarrollo"] == null)
					return Redirect::to('plan_desarrollo/index');

				return View::make('rrhh/planes_desarrollo/edit',$data);
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
					'nombre_documento' => 'Nombre del Documento',
					'autor_documento' => 'Nombre del Autor',
					'codigo_documento' => 'Código de Archivamiento',
					'descripcion_documento' => 'Descripción del Documento',					
					'archivo' => 'Plan de Desarrollo de RRHH'
					);

				$messages=array(
					);

				$rules = array(
					'nombre_documento' => 'required|max:200',
					'autor_documento' => 'required|max:200',
					'codigo_documento' => 'required|max:100',
					'descripcion_documento' => 'required|max:200',					
					'archivo' => ''				
					);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to('plan_desarrollo/edit')->withErrors($validator)->withInput(Input::all());
				}else{

					$plan_desarrollo = PLanDesarrollo::find($id);

					if($plan_desarrollo == null)
						return Redirect::to('plan_desarrollo/index');
					
					$plan_desarrollo->nombre = Input::get('nombre_documento');
					$plan_desarrollo->autor = Input::get('autor_documento');
					$plan_desarrollo->descripcion = Input::get('descripcion_documento');
					$plan_desarrollo->codigo_archivamiento = Input::get('codigo_documento');					

					if(Input::hasFile('archivo'))
					{
						$rutaArchivoEliminar = $plan_desarrollo->url.$plan_desarrollo->nombre_archivo_encriptado;

						if(File::exists($rutaArchivoEliminar))
							File::delete($rutaArchivoEliminar);

						$archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/RRHH/Plan de Desarrollo/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);						
						
						$plan_desarrollo->nombre_archivo = $nombreArchivo;
						$plan_desarrollo->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$plan_desarrollo->url = $rutaDestino;
					}

					$plan_desarrollo->save();
					
					return Redirect::to('plan_desarrollo/index')->with('message', 'Se actualizó correctamente el plan de desarrollo de rrhh.');
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
				$id = Input::get("id_plan_desarrollo");

				$plan_desarrollo = PLanDesarrollo::find($id);
				

				if($plan_desarrollo != null)
				{
					$plan_desarrollo->delete();
					return Redirect::to('plan_desarrollo/index');
				}
					

				return Redirect::to('plan_desarrollo/index');
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
				$data["plan_desarrollo"] = PLanDesarrollo::find($id);

				if($data["plan_desarrollo"] == null)
					return Redirect::to('plan_desarrollo/index');

				$rutaDestino = $data["plan_desarrollo"]->url.$data["plan_desarrollo"]->nombre_archivo_encriptado;

		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );

		        return Response::download($rutaDestino,basename($data["plan_desarrollo"]->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
	
}