<?php

class EventosAdversosController extends BaseController
{
	public function list_eventos_adversos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				
				$data["search_numero_reporte"] = null;
				$data["search_tipo"] = null;
				$data["search_usuario"] = null;
				$data["search_fecha_ini"] = null;
				$data["search_fecha_fin"] = null;
				$data["tipo_eventos"] = TipoEventosAdversos::lists('nombre','id');
				$data["eventos_adversos_data"] = EventoAdverso::getEventosInfo()->distinct()->paginate(10);
				return View::make('riesgos/eventos_adversos/listEventosAdversos',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_evento_adverso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1)
			{
				$data["tipo_eventos"] = TipoEventosAdversos::lists('nombre','id');
				$data["search_numero_reporte"] = Input::get('search_numero_reporte');
				$data["search_tipo"] = Input::get('search_tipo');
				$data["search_usuario"] = Input::get('search_usuario');
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');

				$data["eventos_adversos_data"] = EventoAdverso::searchEventosAdversos($data["search_numero_reporte"],$data["search_tipo"],$data["search_usuario"],$data["search_fecha_ini"],$data["search_fecha_fin"])->distinct()->paginate(10);
				
				return View::make('riesgos/eventos_adversos/listEventosAdversos',$data);	
				
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_evento_adverso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){

				$data["tipo_documentos"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["sexos"] = array('M'=>'Masculino','F'=>'Femenino');
				$data["tipos_incidentes"] = TipoIncidente::lists('nombre','id');
				$data["tipos_frecuencias"] = FrecuenciaIncidente::lists('nombre','id');
				$data["grados_danhos"] = GradoDanho::lists('nombre','id');
				$data["entorno_asistenciales"] = EntornoAsistencial::lists('nombre','id');
				$data["factores"] = FactoresContribuyentes::lists('nombre','id');
				$data["procesos"] = Proceso::lists('nombre','id');
				$data["implicancias"] = PersonasImplicadas::lists('nombre','id');
				return View::make('riesgos/eventos_adversos/createEventoAdverso',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_evento_adverso(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				 
				$checkbox = Input::get('checkbox_equipo');

				$attributes = array(
					'nombre_paciente' => 'Nombre del Paciente',
					'tipo_documento' => 'Tipo de Documento de Identida',
					'numero_documento' => 'Número de Documento',
					'edad' => 'Edad',
					'sexo' => 'Sexo',
					'fecha_reporte' => 'Fecha de Reporte',
					'fecha_incidente' => 'Fecha del Incidente',
					'frecuencia' => 'Frecuencia',
					'tipo_incidente' => 'Tipo de Incidente',
					'subtipopadre_incidente' => 'Subclasificación 1 de Tipo de Incidente',					
					'tipo_danho' => 'Tipo de Daño',
					'grado_danho' => 'Grado de Daño',
					'impacto_socioeconomico' => 'Impacto Social y/o Económico',
					'procedimiento' => 'Procedimiento',
					'diagnostico' => 'Diagnóstico',
					'causa' => 'Causas',
					'medidas' => 'Medidas',
					'codigo_patrimonial' => 'Equipo Involucrado',
					'informacion' => 'Información Adicional',
					'nombre_reportante' => 'Nombre del Reportante',
					'profesion' => 'Profesión o Cargo',
					'direccion' => 'Dirección',
					'email' => 'E-mail',
					'disciplina' => 'Disciplina / Especialidad',
					'entorno_asistencial' => 'Entorno Asistencial',
					'proceso' => 'Procesos',
					'factor' => 'Factor Contribuyente',
					'danho_bienes' => 'Daño de Bienes',
				);



				$messages = array(
					);

				$rules = array(
					'nombre_paciente' => 'required|alpha_spaces',
					'tipo_documento' => 'required',
					'numero_documento' => 'required|numeric',
					'edad' => 'required',
					'sexo' => 'required',
					'fecha_reporte' => 'required',
					'fecha_incidente' => 'required',
					'frecuencia' => 'required',
					'tipo_incidente' => 'required',
					'subtipopadre_incidente' => 'required',
					'subtipohijo_incidente' => 'required',
					'tipo_danho' => 'required|alpha_spaces',
					'grado_danho' => 'required',
					'impacto_socioeconomico' => 'required|alpha_num_spaces_slash_dash_enter',
					'procedimiento' => 'required|alpha_num_spaces_slash_dash_enter',
					'diagnostico' => 'required|alpha_num_spaces_slash_dash_enter',
					'causa' => 'required|alpha_num_spaces_slash_dash_enter',
					'medidas' => 'required|alpha_num_spaces_slash_dash_enter',
					'informacion' => 'required|alpha_num_spaces_slash_dash_enter',
					'nombre_reportante' => 'required|alpha_spaces',
					'profesion' => 'required|alpha_num_spaces',
					'direccion' => 'required|alpha_num_spaces',
					'email' => 'required|email',
					'disciplina' => 'required|alpha_num_spaces',
					'entorno_asistencial' => 'required',
					'proceso' => 'required',
					'factor' => 'required',
					'danho_bienes' => 'required|alpha_num_spaces',
				);

	

				$flag = Input::get('flag_tipoHijo');
				if($flag == 0){
					$element_attribute = array('subtipohijo_incidente' => 'Subclasificación 2 de Tipo de Incidente');
					$element_rule = array('subtipohijo_incidente' => 'required');
					$attributes += $element_attribute;
					$rules += $element_rule;
				}else{
					$element_attribute = array('subtipohijo_incidente' => 'Tipo de Caída');
					$element_rule = array('subtipohijo_incidente' => 'required');
					$element_attribute2 = array('subtipohijo2_incidente' => 'Elemento Implicado en la Caída');
					$element_rule2 = array('subtipohijo2_incidente' => 'required');
					$attributes += $element_attribute+$element_attribute2;
					$rules += $element_rule+$element_rule2;					
				}

				$flag_entorno = Input::get('flag_entornoAsistencial');
				if($flag_entorno == 0){
					$element_attribute = array('tipo_servicio' => 'Tipo de Servicio');
					$element_attribute2 = array('etapa_servicio' => 'Etapa de Servicio');
					$element_rule = array('tipo_servicio' => 'required');
					$element_rule2 = array('etapa_servicio' => 'required');
					$attributes += $element_attribute;
					$attributes += $element_attribute2;
					$rules += $element_rule;
					$rules += $element_rule2;
				}else{
					$element_attribute = array('comentario' => 'Observaciones');
					$element_rule = array('comentario' => 'required');
					$attributes += $element_attribute;
					$rules += $element_rule;				
				}

				if($checkbox == true ){
					$element_rule = array('codigo_patrimonial' => 'required');
					$rules += $element_rule;
				}	

				

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);
				

				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('eventos_adversos/create_evento_adverso')->withErrors($validator)->withInput(Input::all());
				}else{				

					$personas_implicadas = Input::get('personas_implicadas');
					$cantidad_personas = count($personas_implicadas);
					if($cantidad_personas > 0){

						$cantidades = Input::get('cantidades');
						$personas_implicadas = Input::get('personas_implicadas');

						$evento = new EventoAdverso;
					
						//PONEMOS EL CODIGO
						$abreviatura = "EA";
						$string = $this->getCorrelativeReportNumber();

						$evento->codigo_abreviatura = $abreviatura;
						$evento->codigo_correlativo = $string;
						$evento->codigo_anho = date('y');
						//INFORMACIÓN SOBRE EL PACIENTE
						$evento->nombre_paciente = Input::get('nombre_paciente');
						$evento->idtipo_documento = Input::get('tipo_documento');
						$evento->numero_documento = Input::get('numero_documento');
						$evento->edad = Input::get('edad');
						$evento->sexo = Input::get('sexo');

						//Fechas
						$evento->fecha_reporte = date("Y-m-d",strtotime(Input::get('fecha_reporte')));
						$evento->fecha_incidente = date("Y-m-d H:i:s",strtotime(Input::get('fecha_incidente')));
						
						//Campo Pendiente en Clasificacion del Incidente
						$evento->idfrecuencia = Input::get('frecuencia');
						
						//RESULTADOS DEL PACIENTE
						$evento->tipo_danho = Input::get('tipo_danho');
						$evento->idgrado_danho = Input::get('grado_danho');	

						//IMPACTO SOCIOECONOMICO
						$evento->impacto_socioeconomico = Input::get('impacto_socioeconomico');
						
						//CARACTERISTICAS DEL INCIDENTE
						$evento->idproceso = Input::get('proceso');
						$evento->idfactor = Input::get('factor');
						$evento->disciplina = Input::get('disciplina');
						$evento->danho_bienes = Input::get('danho_bienes');

						//DESCRIPCION DEL INCIDENTE
						$evento->procedimiento = Input::get('procedimiento');
						$evento->diagnostico = Input::get('diagnostico');
						$evento->causa = Input::get('causa');
						$evento->medidas = Input::get('medidas');

						//ACTIVO
						if($checkbox == true){
							$activo = Activo::searchActivosByCodigoPatrimonial(Input::get('codigo_patrimonial'))->get()[0];
							$evento->idactivo = $activo->idactivo;
						}
						//INFORMACION ADICIONAL
						$evento->informacion = Input::get('informacion');

						//USUARIO REPORTANTE 
						$evento->nombre_reportante = Input::get('nombre_reportante');
						$evento->profesion = Input::get('profesion');
						$evento->direccion = Input::get('direccion');
						$evento->email = Input::get('email');

						
						$evento->save();

						/*REGISTRO DE LA CLASIFICACION DEL INCIDENTE*/
						
						$tipo_clasificacion1 = Input::get('subtipopadre_incidente');
						//verificamos si es "caidas" o no
						if($tipo_clasificacion1 == 33){
							//es caida!
							//I) para el tipo de caida
							$eventoxsubtipohijo1 = new EventoxSubTipoHijo;
							$eventoxsubtipohijo1->idevento = $evento->id;
							$eventoxsubtipohijo1->idsubtipohijo = 192;
							$eventoxsubtipohijo1->save();
							//II) para el elemento de caida
							$eventoxsubtipohijo2 = new EventoxSubTipoHijo;
							$eventoxsubtipohijo2->idevento = $evento->id;
							$eventoxsubtipohijo2->idsubtipohijo = 193;
							$eventoxsubtipohijo2->save();
							//III)registramos el nieto 1 (Elección en Tipo de Caida)
							$eventoxsubtipohijoxsubtiponieto1 = new EventoxSubTipoHijoxSubTipoNieto;
							$eventoxsubtipohijoxsubtiponieto1->ideventoxhijo = $eventoxsubtipohijo1->id;
							$eventoxsubtipohijoxsubtiponieto1->idsubtiponieto = Input::get('subtipohijo_incidente');	;
							$eventoxsubtipohijoxsubtiponieto1->save();
							//III)registramos el nieto 2 (Elección en Elemento de Tipo de Caida)
							$eventoxsubtipohijoxsubtiponieto2 = new EventoxSubTipoHijoxSubTipoNieto;
							$eventoxsubtipohijoxsubtiponieto2->ideventoxhijo = $eventoxsubtipohijo2->id;
							$eventoxsubtipohijoxsubtiponieto2->idsubtiponieto = Input::get('subtipohijo2_incidente');	;
							$eventoxsubtipohijoxsubtiponieto2->save();
						}else{
							//no es caida!
							$eventoxsubtipohijo = new EventoxSubTipoHijo;
							$eventoxsubtipohijo->idevento = $evento->id;
							$eventoxsubtipohijo->idsubtipohijo = Input::get('subtipohijo_incidente');
							$eventoxsubtipohijo->save();
						} 

						/*REGISTRO DE ENTORNO ASISTENCIAL*/
						$entorno_asistencial = Input::get('entorno_asistencial');
						if($entorno_asistencial == 6 || $entorno_asistencial==49 || $entorno_asistencial == 8){
							//es elemento que contiene un comentario
							$eventoxentorno = new EventoxEntornoAsistencial;
							$eventoxentorno->identorno = $entorno_asistencial;
							$eventoxentorno->idevento = $evento->id;
							$eventoxentorno->comentario = Input::get('comentario');
							$eventoxentorno->save();
						}else{
							$idetapa_servicio = Input::get('etapa_servicio');
							$evento->idetapa_servicio = $idetapa_servicio;						
							$evento->save();
						}

						/*REGISTRO DE LAS PERSONAS IMPLICADAS*/

						for($i=0;$i<$cantidad_personas;$i++){
							$eventoxpersonas = new EventoxPersonasImplicadas;
							$nombre_tipo = $personas_implicadas[$i];
							$tipo = PersonasImplicadas::getTipoByNombre($nombre_tipo)->get()[0];
							$cantidad = $cantidades[$i];
							$eventoxpersonas->idevento = $evento->id;
							$eventoxpersonas->idpersonas_implicada = $tipo->id;
							$eventoxpersonas->cantidad = $cantidad;
							$eventoxpersonas->save();
						}

					}else{
						Session::flash('error', 'No se han registrado personas implicadas.');
						return Redirect::to('eventos_adversos/create_evento_adverso')->withInput(Input::all());
					}					
					return Redirect::to('eventos_adversos/list_eventos_adversos')->with('message', 'Se registró correctamente el reporte '.$evento->codigo_abreviatura.'-'.$evento->codigo_correlativo.'-'.$evento->codigo_anho);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_evento_adverso($idevento=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){

				$data["evento_adverso_info"] = EventoAdverso::searchEventoAdversoById($idevento)->get();

				if($data["evento_adverso_info"]->isEmpty())
				{
					return Redirect::to('eventos_adversos/list_eventos_adversos');
				}

				$data["evento_adverso_info"] = $data["evento_adverso_info"][0];
				if($data["evento_adverso_info"]->idactivo == null)
					$data["activo_info"] = null;
				else{
					$activo = Activo::find($data["evento_adverso_info"]->idactivo);
					$data["activo_info"] = Activo::searchActivosByCodigoPatrimonial($activo->codigo_patrimonial)->get();
					$data["activo_info"] = $data["activo_info"][0];
				}
				

				//sacaremos los datos de la clasificacion
				$data["subtipohijo_info"] = EventoxSubTipoHijo::searchEventoXSubTiposById($data["evento_adverso_info"]->id)->get();
				if(count($data["subtipohijo_info"])==2){
					//quiere decir que es de caidas
					$data["subtipohijo_nieto1"] = EventoxSubTipoHijoxSubTipoNieto::searchEventoXSubTiposById($data["subtipohijo_info"][0]->id)->get()[0];
					$data["subtipohijo_nieto2"] = EventoxSubTipoHijoxSubTipoNieto::searchEventoXSubTiposById($data["subtipohijo_info"][1]->id)->get()[0];
					$data["flag_tipoHijo"] = 1;
				}else{
					$data["subtipohijo_nieto1"] = null;
					$data["subtipohijo_nieto2"] = null;
					$data["flag_tipoHijo"] = 0;
				}
				$data["subtipohijo_info"] = $data["subtipohijo_info"][0];

				//sacamos los datos del entorno asistencial
				if($data["evento_adverso_info"]->idetapa_servicio == null){
					//quiere decir que hay un comentario
					$data["entorno_asistencial"] = EventoxEntornoAsistencial::searchEntornoAsistencialByIdEvento($data["evento_adverso_info"]->id)->get()[0];
					$data["etapa_servicio"] = null;
					/*echo '<pre>';
					print_r($data["entorno_asistencial"]->comentario);
					exit;*/			
				}else{
					$data["etapa_servicio"] = EtapaServicio::getEtapaServiciosByIdEtapaServicio($data["evento_adverso_info"]->idetapa_servicio)->get()[0];
					$data["entorno_asistencial"] = null;
					/*echo '<pre>';
					print_r($data["etapa_servicio"][0]);
					exit;*/
				}

				$data["personas_implicadas"] = EventoxPersonasImplicadas::getPersonasImplicadasByIdEvento($data["evento_adverso_info"]->id)->get();
				$data["cantidad_personas"] = count($data["personas_implicadas"]);
				
				$data["tipo_documentos"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["sexos"] = array('M'=>'Masculino','F'=>'Femenino');
				$data["tipos_incidentes"] = TipoIncidente::lists('nombre','id');
				$data["tipos_frecuencias"] = FrecuenciaIncidente::lists('nombre','id');
				$data["entorno_asistenciales"] = EntornoAsistencial::lists('nombre','id');
				$data["grados_danhos"] = GradoDanho::lists('nombre','id');
				$data["implicancias"] = PersonasImplicadas::lists('nombre','id');
				$data["factores"] = FactoresContribuyentes::lists('nombre','id');
				$data["procesos"] = Proceso::lists('nombre','id');
				
				return View::make('riesgos/eventos_adversos/editEventoAdverso',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_evento_adverso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				
				$checkbox = Input::get('checkbox_equipo');

				$attributes = array(
					'nombre_paciente' => 'Nombre del Paciente',
					'tipo_documento' => 'Tipo de Documento de Identida',
					'numero_documento' => 'Número de Documento',
					'edad' => 'Edad',
					'sexo' => 'Sexo',
					'fecha_reporte' => 'Fecha de Reporte',
					'fecha_incidente' => 'Fecha del Incidente',
					'frecuencia' => 'Frecuencia',
					'tipo_incidente' => 'Tipo de Incidente',
					'subtipopadre_incidente' => 'Subclasificación 1 de Tipo de Incidente',					
					'tipo_danho' => 'Tipo de Daño',
					'grado_danho' => 'Grado de Daño',
					'impacto_socioeconomico' => 'Impacto Social y/o Económico',
					'procedimiento' => 'Procedimiento',
					'diagnostico' => 'Diagnóstico',
					'causa' => 'Causas',
					'medidas' => 'Medidas',
					'codigo_patrimonial' => 'Equipo Involucrado',
					'informacion' => 'Información Adicional',
					'nombre_reportante' => 'Nombre del Reportante',
					'profesion' => 'Profesión o Cargo',
					'direccion' => 'Dirección',
					'email' => 'E-mail',
					'disciplina' => 'Disciplina / Especialidad',
					'entorno_asistencial' => 'Entorno Asistencial',
					'proceso' => 'Procesos',
					'factor' => 'Factor Contribuyente',
					'danho_bienes' => 'Daño de Bienes',
				);



				$messages = array(
					);

				$rules = array(
					'nombre_paciente' => 'required|alpha_spaces',
					'tipo_documento' => 'required',
					'numero_documento' => 'required|numeric',
					'edad' => 'required',
					'sexo' => 'required',
					'fecha_reporte' => 'required',
					'fecha_incidente' => 'required',
					'frecuencia' => 'required',
					'tipo_incidente' => 'required',
					'subtipopadre_incidente' => 'required',
					'subtipohijo_incidente' => 'required',
					'tipo_danho' => 'required',
					'grado_danho' => 'required',
					'impacto_socioeconomico' => 'required|alpha_num_spaces_slash_dash_enter',
					'procedimiento' => 'required|alpha_num_spaces_slash_dash_enter',
					'diagnostico' => 'required|alpha_num_spaces_slash_dash_enter',
					'causa' => 'required|alpha_num_spaces_slash_dash_enter',
					'medidas' => 'required|alpha_num_spaces_slash_dash_enter',
					'informacion' => 'required|alpha_num_spaces_slash_dash_enter',
					'nombre_reportante' => 'required|alpha_spaces',
					'profesion' => 'required|alpha_num_spaces',
					'direccion' => 'required|alpha_num_spaces',
					'email' => 'required|email',
					'disciplina' => 'required|alpha_num_spaces',
					'entorno_asistencial' => 'required',
					'proceso' => 'required',
					'factor' => 'required',
					'danho_bienes' => 'required|alpha_num_spaces',
				);

				$flag = Input::get('flag_tipoHijo');
				if($flag == 0){
					$element_attribute = array('subtipohijo_incidente' => 'Subclasificación 2 de Tipo de Incidente');
					$element_rule = array('subtipohijo_incidente' => 'required');
					$attributes += $element_attribute;
					$rules += $element_rule;
				}else{
					$element_attribute = array('subtipohijo_incidente' => 'Tipo de Caída');
					$element_rule = array('subtipohijo_incidente' => 'required');
					$element_attribute2 = array('subtipohijo2_incidente' => 'Elemento Implicado en la Caída');
					$element_rule2 = array('subtipohijo2_incidente' => 'required');
					$attributes += $element_attribute+$element_attribute2;
					$rules += $element_rule+$element_rule2;					
				}

				$flag_entorno = Input::get('flag_entornoAsistencial');
				if($flag_entorno == 0){
					$element_attribute = array('tipo_servicio' => 'Tipo de Servicio');
					$element_attribute2 = array('etapa_servicio' => 'Etapa de Servicio');
					$element_rule = array('tipo_servicio' => 'required');
					$element_rule2 = array('etapa_servicio' => 'required');
					$attributes += $element_attribute;
					$attributes += $element_attribute2;
					$rules += $element_rule;
					$rules += $element_rule2;
				}else{
					$element_attribute = array('comentario' => 'Observaciones');
					$element_rule = array('comentario' => 'required');
					$attributes += $element_attribute;
					$rules += $element_rule;				
				}

				if($checkbox == true ){
					$element_rule = array('codigo_patrimonial' => 'required');
					$rules += $element_rule;
				}	

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$evento_id = Input::get('evento_adverso_id');
					$url = "eventos_adversos/edit_evento_adverso"."/".$evento_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{	
					$evento_id = Input::get('evento_adverso_id');
					$url = "eventos_adversos/edit_evento_adverso"."/".$evento_id;
					$personas_implicadas = Input::get('personas_implicadas');
					$cantidad_personas = count($personas_implicadas); 
					if( $cantidad_personas >0){
						$evento = EventoAdverso::find($evento_id);
					
						//INFORMACIÓN SOBRE EL PACIENTE
						$evento->nombre_paciente = Input::get('nombre_paciente');
						$evento->idtipo_documento = Input::get('tipo_documento');
						$evento->numero_documento = Input::get('numero_documento');
						$evento->edad = Input::get('edad');
						$evento->sexo = Input::get('sexo');

						//Fechas
						$evento->fecha_reporte = date("Y-m-d",strtotime(Input::get('fecha_reporte')));
						$evento->fecha_incidente = date("Y-m-d H:i:s",strtotime(Input::get('fecha_incidente')));
						
						//Campo Pendiente en Clasificacion del Incidente
						$evento->idfrecuencia = Input::get('frecuencia');
						
						//RESULTADOS DEL PACIENTE
						$evento->tipo_danho = Input::get('tipo_danho');
						$evento->idgrado_danho = Input::get('grado_danho');	

						//IMPACTO SOCIOECONOMICO
						$evento->impacto_socioeconomico = Input::get('impacto_socioeconomico');
						
						//CARACTERISTICAS DEL INCIDENTE
						$evento->idproceso = Input::get('proceso');
						$evento->idfactor = Input::get('factor');
						$evento->disciplina = Input::get('disciplina');
						$evento->danho_bienes = Input::get('danho_bienes');

						//DESCRIPCION DEL INCIDENTE
						$evento->procedimiento = Input::get('procedimiento');
						$evento->diagnostico = Input::get('diagnostico');
						$evento->causa = Input::get('causa');
						$evento->medidas = Input::get('medidas');

						//ACTIVO
						if($checkbox == true){
							$activo = Activo::searchActivosByCodigoPatrimonial(Input::get('codigo_patrimonial'))->get()[0];
							$evento->idactivo = $activo->idactivo;
						}else{
							$evento->idactivo = null;
						}
						

						//INFORMACION ADICIONAL
						$evento->informacion = Input::get('informacion');

						//USUARIO REPORTANTE 
						$evento->nombre_reportante = Input::get('nombre_reportante');
						$evento->profesion = Input::get('profesion');
						$evento->direccion = Input::get('direccion');
						$evento->email = Input::get('email');

						$evento->save();

						//Realizar los cambios respecto a la clasificacion del evento adverso
						//1) se debe borrar los registros ya obtenidos para hacer mas limpia la clasificacion
						$eventoxtipoHijo = EventoxSubTipoHijo::searchEventoXSubTiposById($evento->id)->get();
						$count = count($eventoxtipoHijo);
						for($i=0;$i<$count;$i++){
							$eventoxhijo = $eventoxtipoHijo[$i];
							$eventoxtipoHijoxtipoNieto = EventoxSubTipoHijoxSubTipoNieto::searchEventoXSubTiposById($eventoxhijo->id)->get();
							if(!$eventoxtipoHijoxtipoNieto->isEmpty()){		
								$eventoxhijoxnieto = EventoxSubTipoHijoxSubTipoNieto::find($eventoxtipoHijoxtipoNieto[0]->id);
								$eventoxhijoxnieto->forceDelete();
							}
							$eventoxhijo = EventoxSubTipoHijo::find($eventoxhijo->id);
							$eventoxhijo->forceDelete();
						}

						$tipo_clasificacion1 = Input::get('subtipopadre_incidente');
						//verificamos si es "caidas" o no
						if($tipo_clasificacion1 == 33){
							//es caida!
							//I) para el tipo de caida
							$eventoxsubtipohijo1 = new EventoxSubTipoHijo;
							$eventoxsubtipohijo1->idevento = $evento->id;
							$eventoxsubtipohijo1->idsubtipohijo = 192;
							$eventoxsubtipohijo1->save();
							//II) para el elemento de caida
							$eventoxsubtipohijo2 = new EventoxSubTipoHijo;
							$eventoxsubtipohijo2->idevento = $evento->id;
							$eventoxsubtipohijo2->idsubtipohijo = 193;
							$eventoxsubtipohijo2->save();
							//III)registramos el nieto 1 (Elección en Tipo de Caida)
							$eventoxsubtipohijoxsubtiponieto1 = new EventoxSubTipoHijoxSubTipoNieto;
							$eventoxsubtipohijoxsubtiponieto1->ideventoxhijo = $eventoxsubtipohijo1->id;
							$eventoxsubtipohijoxsubtiponieto1->idsubtiponieto = Input::get('subtipohijo_incidente');	;
							$eventoxsubtipohijoxsubtiponieto1->save();
							//III)registramos el nieto 2 (Elección en Elemento de Tipo de Caida)
							$eventoxsubtipohijoxsubtiponieto2 = new EventoxSubTipoHijoxSubTipoNieto;
							$eventoxsubtipohijoxsubtiponieto2->ideventoxhijo = $eventoxsubtipohijo2->id;
							$eventoxsubtipohijoxsubtiponieto2->idsubtiponieto = Input::get('subtipohijo2_incidente');	;
							$eventoxsubtipohijoxsubtiponieto2->save();
						}else{
							//no es caida!
							$eventoxsubtipohijo = new EventoxSubTipoHijo;
							$eventoxsubtipohijo->idevento = $evento->id;
							$eventoxsubtipohijo->idsubtipohijo = Input::get('subtipohijo_incidente');
							$eventoxsubtipohijo->save();
						} 	

						/*EDICIÓN DE ENTORNO ASISTENCIAL*/
							$entorno_asistencial = Input::get('entorno_asistencial');
							if($entorno_asistencial == 6 || $entorno_asistencial==49 || $entorno_asistencial==8){
								//es elemento que contiene un comentario
								$eventoxentorno =  EventoxEntornoAsistencial::searchEntornoAsistencialByIdEvento($evento->id)->get();
								if(!$eventoxentorno->isEmpty()){
									$eventoxentorno=$eventoxentorno[0];
									if($entorno_asistencial == $eventoxentorno ){
										//quiere decir que el usuario no cambio de tipo de entorno solo cambiamos el comentario
										$eventoxentorno->comentario = Input::get('comentario');
										$eventoxentorno->save();
									}else{
										//el usuario eligio otro
										$eventoxentorno->identorno = $entorno_asistencial;
										$eventoxentorno->comentario = Input::get('comentario');
										$eventoxentorno->save();
									}
								}else{
									//quiere decir que el usuario ya no quiere tener una etapa de servicio
									$evento->idetapa_servicio = null;
									$evento->save();
									$eventoxentorno = new EventoxEntornoAsistencial;
									$eventoxentorno->identorno = $entorno_asistencial;
									$eventoxentorno->idevento = $evento->id;
									$eventoxentorno->comentario = Input::get('comentario');
									$eventoxentorno->save();
								}
							}else{
								$idetapa_servicio = Input::get('etapa_servicio');
								$evento->idetapa_servicio = $idetapa_servicio;						
								$evento->save();
								//eliminamos el comentario que existió alguna vez
								$eventoxentorno =  EventoxEntornoAsistencial::searchEntornoAsistencialByIdEvento($evento->id)->get();
								if(!$eventoxentorno->isEmpty()){
									$eventoxentorno[0]->forceDelete();
								}
							}

							/*REGISTRO DE LAS PERSONAS IMPLICADAS*/
							$personas = EventoxPersonasImplicadas::getPersonasImplicadasByIdEvento($evento->id)->forceDelete();

							$cantidades = Input::get('cantidades');
							/*REGISTRO DE LAS PERSONAS IMPLICADAS*/
							for($i=0;$i<$cantidad_personas;$i++){
								$eventoxpersonas = new EventoxPersonasImplicadas;
								$nombre_tipo = $personas_implicadas[$i];

								$tipo = PersonasImplicadas::getTipoByNombre($nombre_tipo)->get()[0];
								$cantidad = $cantidades[$i];
								$eventoxpersonas->idevento = $evento->id;
								$eventoxpersonas->idpersonas_implicada = $tipo->id;
								$eventoxpersonas->cantidad = $cantidad;
								$eventoxpersonas->save();
							}


							return Redirect::to('eventos_adversos/list_eventos_adversos')->with('message', 'Se editó correctamente el evento adverso '.$evento->codigo_abreviatura.'-'.$evento->codigo_correlativo.'-'.$evento->codigo_anho);
					}else{
						Session::flash('error', 'No se han registrado personas implicadas.');
						$evento_id = Input::get('evento_adverso_id');
						$url = "eventos_adversos/edit_evento_adverso"."/".$evento_id;
						return Redirect::to($url)->withInput(Input::all());
					}

					

					
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_evento_adverso($idevento=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){

				$data["evento_adverso_info"] = EventoAdverso::searchEventoAdversoById($idevento)->get();

				if($data["evento_adverso_info"]->isEmpty())
				{
					return Redirect::to('eventos_adversos/list_eventos_adversos');
				}

				$data["evento_adverso_info"] = $data["evento_adverso_info"][0];
				if($data["evento_adverso_info"]->idactivo == null)
					$data["activo_info"] = null;
				else{
					$activo = Activo::find($data["evento_adverso_info"]->idactivo);
					$data["activo_info"] = Activo::searchActivosByCodigoPatrimonial($activo->codigo_patrimonial)->get();
					$data["activo_info"] = $data["activo_info"][0];
				}

				//sacaremos los datos de la clasificacion
				$data["subtipohijo_info"] = EventoxSubTipoHijo::searchEventoXSubTiposById($data["evento_adverso_info"]->id)->get();
				if(count($data["subtipohijo_info"])==2){
					//quiere decir que es de caidas
					$data["subtipohijo_nieto1"] = EventoxSubTipoHijoxSubTipoNieto::searchEventoXSubTiposById($data["subtipohijo_info"][0]->id)->get()[0];
					$data["subtipohijo_nieto2"] = EventoxSubTipoHijoxSubTipoNieto::searchEventoXSubTiposById($data["subtipohijo_info"][1]->id)->get()[0];
					$data["flag_tipoHijo"] = 1;
				}else{
					$data["subtipohijo_nieto1"] = null;
					$data["subtipohijo_nieto2"] = null;
					$data["flag_tipoHijo"] = 0;
				}
				$data["subtipohijo_info"] = $data["subtipohijo_info"][0];

				//sacamos los datos del entorno asistencial
				if($data["evento_adverso_info"]->idetapa_servicio == null){
					//quiere decir que hay un comentario
					$data["entorno_asistencial"] = EventoxEntornoAsistencial::searchEntornoAsistencialByIdEvento($data["evento_adverso_info"]->id)->get()[0];
					$data["etapa_servicio"] = null;
					/*echo '<pre>';
					print_r($data["entorno_asistencial"]->comentario);
					exit;*/			
				}else{
					$data["etapa_servicio"] = EtapaServicio::getEtapaServiciosByIdEtapaServicio($data["evento_adverso_info"]->idetapa_servicio)->get()[0];
					$data["entorno_asistencial"] = null;
					/*echo '<pre>';
					print_r($data["etapa_servicio"][0]);
					exit;*/
				}

				$data["personas_implicadas"] = EventoxPersonasImplicadas::getPersonasImplicadasByIdEvento($data["evento_adverso_info"]->id)->get();
				$data["cantidad_personas"] = count($data["personas_implicadas"]);

				$data["tipo_documentos"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["sexos"] = array('M'=>'Masculino','F'=>'Femenino');
				$data["tipos_incidentes"] = TipoIncidente::lists('nombre','id');
				$data["tipos_frecuencias"] = FrecuenciaIncidente::lists('nombre','id');
				$data["grados_danhos"] = GradoDanho::lists('nombre','id');
				$data["entorno_asistenciales"] = EntornoAsistencial::lists('nombre','id');
				$data["implicancias"] = PersonasImplicadas::lists('nombre','id');
				$data["factores"] = FactoresContribuyentes::lists('nombre','id');
				$data["procesos"] = Proceso::lists('nombre','id');
				
				return View::make('riesgos/eventos_adversos/viewEventoAdverso',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function show_subtipospadres(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('idtipo_incidente');
			//$array_subtipospadres = "hola";
			$array_subtipospadres = SubTipoPadreIncidente::getSubTiposByIdTipoIncidente($data)->get()->toArray();

			return Response::json(array( 'success' => true, 'array_subtipos' => $array_subtipospadres ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function show_subtiposhijos(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('idsubtipopadre');			
			$array_subtiposhijos = SubTipoHijoIncidente::getSubTiposByIdSubtipoPadre($data)->get()->toArray();

			return Response::json(array( 'success' => true, 'array_subtipos' => $array_subtiposhijos ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function show_subtiposnietos(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('idsubtipohijo');			
			$array_subtiposnietos = SubTipoNietoIncidente::getSubTiposByIdSubtipoHijo($data)->get()->toArray();

			return Response::json(array( 'success' => true, 'array_subtipos' => $array_subtiposnietos ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function show_tiposServicios(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('identorno_asistencial');			
			$array_subtipos = EntornoAsistencialxTipoServicio::getTipoServiciosByIdEntornoAsistencial($data)->get()->toArray();

			return Response::json(array( 'success' => true, 'array_subtipos' => $array_subtipos ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function show_etapasServicios(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('idtipo_servicio');	
			$entorno_asistencial = Input::get('identorno_asistencial');		
			$array_subtipos = EtapaServicio::getEtapaServiciosByIdTipoServicio($data,$entorno_asistencial)->get()->toArray();

			return Response::json(array( 'success' => true, 'array_subtipos' => $array_subtipos ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function fill_activo_info(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('codigo_patrimonial');			
			$activo = Activo::searchActivosByCodigoPatrimonial($data)->get();
			if($activo->isEmpty())
				$activo = null;
			else
				$activo = $activo[0];

			return Response::json(array( 'success' => true, 'activo' => $activo ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function export_pdf()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){

				$evento_id = Input::get('evento_adverso_id');					
				$data["evento_adverso_info"] = EventoAdverso::searchEventoAdversoById($evento_id)->get();

				if($data["evento_adverso_info"]->isEmpty())
				{
					return Redirect::to('eventos_adversos/list_eventos_adversos');
				}

				$data["evento_adverso_info"] = $data["evento_adverso_info"][0];
				if($data["evento_adverso_info"]->idactivo == null)
					$data["activo_info"] = null;
				else{
					$activo = Activo::find($data["evento_adverso_info"]->idactivo);
					$data["activo_info"] = Activo::searchActivosByCodigoPatrimonial($activo->codigo_patrimonial)->get();
					$data["activo_info"] = $data["activo_info"][0];
				}

				//sacaremos los datos de la clasificacion
				$data["subtipohijo_info"] = EventoxSubTipoHijo::searchEventoXSubTiposById($data["evento_adverso_info"]->id)->get();
				if(count($data["subtipohijo_info"])==2){
					//quiere decir que es de caidas
					$data["subtipohijo_nieto1"] = EventoxSubTipoHijoxSubTipoNieto::searchEventoXSubTiposById($data["subtipohijo_info"][0]->id)->get()[0];
					$data["nieto1"] = SubTipoNietoIncidente::find($data["subtipohijo_nieto1"]->idsubtiponieto_incidente);
					$data["subtipohijo_nieto2"] = EventoxSubTipoHijoxSubTipoNieto::searchEventoXSubTiposById($data["subtipohijo_info"][1]->id)->get()[0];
					$data["nieto2"] = SubTipoNietoIncidente::find($data["subtipohijo_nieto2"]->idsubtiponieto_incidente);
					$data["flag_tipoHijo"] = 1;
				}else{
					$data["subtipohijo_nieto1"] = null;
					$data["subtipohijo_nieto2"] = null;
					$data["nieto1"] = null;
					$data["nieto2"] = null;
					$data["flag_tipoHijo"] = 0;
				}
				$data["subtipohijo_info"] = $data["subtipohijo_info"][0];
				$data["hijo"] = SubTipoHijoIncidente::find($data["subtipohijo_info"]->idsubtipohijo);
				$data["padre"] = SubTipoPadreIncidente::find($data["subtipohijo_info"]->idsubtipopadre_incidente);
				$data["tipo_incidente"] = TipoIncidente::find($data["subtipohijo_info"]->idtipo_incidente);

				$data["tipo_documento"] = TipoDocumento::find($data["evento_adverso_info"]->idtipo_documento);
				if($data["evento_adverso_info"] === 'M')
					$data["sexo"] = 'Masculino';
				else
					$data["sexo"] = 'Femenino';

				//sacamos los datos del entorno asistencial
				if($data["evento_adverso_info"]->idetapa_servicio == null){
					//quiere decir que hay un comentario
					$data["entorno_asistencial"] = EventoxEntornoAsistencial::searchEntornoAsistencialByIdEvento($data["evento_adverso_info"]->id)->get()[0];
					$data["etapa_servicio"] = null;
					/*echo '<pre>';
					print_r($data["entorno_asistencial"]);
					exit;*/			
				}else{
					$data["etapa_servicio"] = EtapaServicio::getEtapaServiciosByIdEtapaServicio($data["evento_adverso_info"]->idetapa_servicio)->get()[0];
					
					$data["entorno_asistencial"] = EntornoAsistencial::find($data["etapa_servicio"]->identorno);
					/*echo '<pre>';
					print_r($data["etapa_servicio"][0]);
					exit;*/
				}

				$data["personas_implicadas"] = EventoxPersonasImplicadas::getPersonasImplicadasByIdEvento($data["evento_adverso_info"]->id)->get();
				$data["cantidad_personas"] = count($data["personas_implicadas"]);
				
				$data["tipos_frecuencias"] = FrecuenciaIncidente::find($data["evento_adverso_info"]->idfrecuencia);
				$data["grados_danhos"] = GradoDanho::find($data["evento_adverso_info"]->idgrado_danho);
				$data["factores"] = FactoresContribuyentes::find($data["evento_adverso_info"]->idfactor);
				$data["procesos"] = Proceso::find($data["evento_adverso_info"]->idproceso);
				
				$html = View::make('riesgos/eventos_adversos/exportEventoAdverso',$data);
				return PDF::load($html,"A4","portrait")->download('Reporte Evento Adverso N° '.$data["evento_adverso_info"]->id);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function getCorrelativeReportNumber(){
		$evento = EventoAdverso::getLastEventoAdverso()->first();
		$string = "";
		if($evento!=null){	
			$numero = $evento->codigo_correlativo;
			$cantidad_digitos = strlen($numero+1);						
			for($i=0;$i<4-$cantidad_digitos;$i++){
				$string = $string."0";
			}
			$string = $string.($numero+1);					
		}else{
			$string = "0001";
		}
		return $string;
	}

	public function submit_disable_evento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$evento_id = Input::get('evento_id');
				$url = "eventos_adversos/edit_evento_adverso"."/".$evento_id;
				$evento = EventoAdverso::find($evento_id);
				$evento->delete();
				Session::flash('message', 'Se inhabilitó correctamente el evento.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_evento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$evento_id = Input::get('evento_id');
				$url = "eventos_adversos/edit_evento_adverso"."/".$evento_id;
				$evento = EventoAdverso::searchEventoAdversoById($evento_id)->get();
				if(!$evento->isEmpty()){
					$evento[0]->restore();
				}else{
					Session::flash('error', 'No se pudo habilitar el evento.');
					return Redirect::to($url);
				}
				
				Session::flash('message', 'Se habilitó correctamente el evento.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}