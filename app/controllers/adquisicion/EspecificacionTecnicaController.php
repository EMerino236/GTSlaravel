<?php

class EspecificacionTecnicaController extends BaseController {

	public function list_especificacion_tecnica()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				$data["familia_activos"] = FamiliaActivo::getNombreEquipo()->get();
				$data["search_familia_activo"] = null;
				$data["tipos_especificacion_tecnica"] = array();
				$data["expedientes_tecnico_data"] = array();				
				return View::make('especificacion_tecnica/listEspecificacionTecnica',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_especificacion_tecnica()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_familia_activo"] = Input::get('search_familia_activo');	
				$data["familia_activos"] = FamiliaActivo::getNombreEquipo()->get();
				$data["especificaciones_tecnica"] = EspecificacionTecnica::GetEspecificacionTecnicaByFamiliaActivoInfo($data["search_familia_activo"])->get();
				$data["tipos_especificacion_tecnica"] = TipoEspecificacionTecnica::select('tipo_especificacion_tecnica.*')->get();
				$data["expedientes_tecnico_data"] = ExpedienteTecnico::getExpedienteTecnicoByFamiliaActivo($data["search_familia_activo"])->paginate(10);	
				return View::make('especificacion_tecnica/listEspecificacionTecnica',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_archivos_ECRI()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				$data["archivos_ECRI_data"] = ArchivoECRI::orderBy('nombre_archivo','asc')->select('archivos_ECRI.*')->get();
				return View::make('especificacion_tecnica/listArchivoECRI',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function download_archivo_ECRI($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$archivo_ECRI = ArchivoECRI::find($id);
				$file= $archivo_ECRI->url.$archivo_ECRI->nombre_archivo;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($archivo_ECRI->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}