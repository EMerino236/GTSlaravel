<?php

class RegistroPerfilController extends \BaseController {

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
				
				$data["search_rol"] = null;
				$data["search_dni"] = null;
				$data["search_nombre"] = null;
				$data["search_pais"] = null;

				$data["paises"] = Pais::all()->lists('nombre','id');

				$data["perfiles_data"] = PlanAprendizaje::withTrashed()->paginate(10);
				
				return View::make('rrhh.registro_perfiles.index',$data);
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
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["paises"] = Pais::all()->lists('nombre','id');
				$data["idiomas"] = Idioma::all()->lists('nombre','id');
				$data["roles"] = [0=>'Docente',1=>'Investigador',2=>'Interno'];
				$data["grados"] = [0=>'Bachiller',1=>'Titulado',2=>'Magister',3=>'Doctorado'];
				$data["niveles_idioma"] = [0=>'Basico',1=>'Intermedio',2=>'Avanzado',3=>'Nulo',4=>'Avanzado Superior'];
				$data["formas_idioma"] = [0=>'Estudio Internacional',1=>'Autodidacta',2=>'Software',3=>'Otros'];
				return View::make('rrhh.registro_perfiles.create',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
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
		//dd(Input::all());
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'nombres' => 'required',
							'apellido_paterno' =>'required',
							'apellido_materno' =>'required',
							'dni' => 'required',
							'pais_nacimiento' => 'required',
							'genero' => 'required',
							'fecha_nacimiento' => 'required',
							'pais_residencia' => 'required',
							'domicilio' => 'required',
							'telefono' => 'required',
							'celular' => 'required',
							'email' => 'required',
							'web' => 'required',
							'institucion' => 'required',
							'archivos' => 'required',
							'rol' => 'required',
							'fa_grados' => 'required',
							'fc_nombres_capacitacion' => 'required',
							'nombres_idioma' => 'required',
							'archivo' => 'required|max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if(Input::has('fa_grados')){
					if(Input::hasFile('archivos')){
						foreach (Input::file('archivos') as $value) {
							if($value == null){
								
								Session::flash('error', 'Se necesita llenar todos los adjuntos en Formación Académica.');
								return Redirect::to('registro_perfil/create')->withErrors($validator)->withInput(Input::except('archivos'));
							}
						}	
					}else{
						
						Session::flash('error', 'Se necesita llenar todos los adjuntos en Formación Académica.');
						return Redirect::to('registro_perfil/create')->withErrors($validator)->withInput(Input::except('archivos'));
					}
					
				}

				if($validator->fails()){
					return Redirect::to('registro_perfil/create')->withErrors($validator)->withInput(Input::except('archivos'));
				}else{
					dd(Input::all());
					$proyecto = new Proyecto;
					$proyecto->nombre = Input::get('nombre');
					$proyecto->id_categoria = Input::get('categoria');
					$proyecto->id_servicio_clinico = Input::get('servicio_clinico');
					$proyecto->id_departamento = Input::get('departamento');
					$proyecto->id_responsable = Input::get('responsable');
					$proyecto->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$proyecto->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
					$proyecto->proposito = Input::get('proposito');
					$proyecto->objetivos = Input::get('objetivos');
					$proyecto->metodologia = Input::get('metodologia');
					$proyecto->descripcion = Input::get('descripcion');
					$proyecto->id_requerimiento = Input::get('id_reporte');

					$proyecto->save();

					$proyecto->codigo = 'P-'.date('Y').'-'.$proyecto->id;

					$proyecto->save();
					
					$requerimientos = Input::get('requerimientos');
					foreach($requerimientos as $requerimiento){
						$proyecto_requerimiento = new ProyectoRequerimiento;
						$proyecto_requerimiento->descripcion = $requerimiento;
						$proyecto_requerimiento->id_proyecto = $proyecto->id;

						$proyecto_requerimiento->save();
					}

					

					Session::flash('message', 'Se registró correctamente el proyecto.');
					return Redirect::to('proyecto/create');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
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
