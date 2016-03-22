<?php

class MaterialSesionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 && $id)
			{
				$data["material_sesion"] = MaterialSesion::find($id);				

				if($data["material_sesion"] == null)
					return Redirect::to('capacitacion/index');

				return View::make('rrhh/material_sesion/show',$data);
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 && $id)
			{
				$data["material_sesion"] = MaterialSesion::find($id);

				if($data["material_sesion"] == null)
					return Redirect::to('capacitacion/index');

				return View::make('rrhh/material_sesion/edit',$data);
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$attributes=array(
					'infraestructura' => 'Infraestructura',
					'equipo' => 'Equipos',
					'herramienta' => 'Herramientas',
					'insumo' => 'Insumos',					
					'equipo_personal' => 'Equipo Personal',					
					'condicion_seguridad' => 'Condiciones de Seguridad'
					);

				$messages=array(
					);

				$rules = array(
					'infraestructura' => 'required|max:500',
					'equipo' => 'required|max:500',
					'herramienta' => 'required|max:500',
					'insumo' => 'required|max:500',					
					'equipo_personal' => 'required|max:500',
					'condicion_seguridad' => 'required|max:500'
					);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){					
					return Redirect::to('material/edit/'.$id)->withErrors($validator)->withInput(Input::all());
				}else{

					$material_sesion = MaterialSesion::find($id);

					$material_sesion->infraestructura = Input::get('infraestructura');
					$material_sesion->equipos = Input::get('equipo');
					$material_sesion->herramientas = Input::get('herramienta');
					$material_sesion->insumos = Input::get('insumo');
					$material_sesion->equipopersonal = Input::get('equipo_personal');
					$material_sesion->condicionesseguridad = Input::get('condicion_seguridad');
					

					$material_sesion->save();
					
					return Redirect::to('capacitacion/show_sesiones/'.$material_sesion->sesion->id_capacitacion)->with('message', 'Se actualizó correctamente los materiales para la sesión N° '.$material_sesion->sesion->numero_sesion);
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
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
