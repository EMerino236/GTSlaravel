@extends('templates/reporteCalibracionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Reporte de Calibración</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>


	@if ($errors->has())
		<div class="alert alert-danger" role="alert" id="rules">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>			
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('error') }}</strong>
		</div>
	@endif

	{{ Form::open(array('url'=>'/reportes_calibracion/search_activos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		{{Form::hidden('type_form',0,array('id'=>'type_form'))}}
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Criterios de Búsqueda de Activos</h3>
		  </div>
		  <div class="panel-body">
		    <div class="row">				
				<div class="col-md-4 form-group">
					{{ Form::label('codigo_patrimonial','Código Patrimonial:') }}
					{{ Form::text('codigo_patrimonial',$codigo_patrimonial,array('class'=>'form-control','placeholder'=>'Código Patrimonial'))  }}
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('nombre_equipo','Nombre del Equipo:') }}				
					{{ Form::text('nombre_equipo',$nombre_equipo,array('class'=>'form-control','placeholder'=>'Nombre del Equipo')) }}
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('servicio','Servicio Clínico:') }}
					{{ Form::select('servicio',array(''=>'Seleccione')+ $servicios ,$servicio,array('class'=>'form-control','placeholder'=>'Servicio Clínico')) }}
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('area','Departamento:') }}				
					{{ Form::select('area',array(''=>'Seleccione')+ $areas, $area,['class' => 'form-control','placeholder'=>'Departamento']) }}				
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('grupo','Grupo:') }}				
					{{ Form::select('grupo', array(''=>'Seleccione')+ $grupos,$grupo,['class' => 'form-control','placeholder'=>'Grupo']) }}				
				</div>				
			</div>
			<div class="row">
				<div class="form-group col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'btnBuscar', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}				
				</div>
				<div class="form-group col-md-2">
					<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
				</div>
			</div>
		  </div>
		</div>
		{{Form::close()}}
		{{ Form::open(array('url'=>'reportes_calibracion/submit_create_reporte_calibracion', 'role'=>'form', 'files'=>true)) }}
			{{Form::hidden('cantidad_activos',count($equipos_data),array('id'=>'cantidad_activos'))}}
		<div class="row">
	    	<div class="col-md-12 form-group">
				<div class="table-responsive">
					<table class="table" id="table_activos">
						<tr class="info">
							<th class="text-nowrap text-center">N°</th>
							<th class="text-nowrap text-center">Grupo</th>
							<th class="text-nowrap text-center">Servicio Clinico</th>
							<th class="text-nowrap text-center">Nombre de Equipo</th>
							<th class="text-nowrap text-center">Marca</th>
							<th class="text-nowrap text-center">Modelo</th>
							<th class="text-nowrap text-center">Código Patrimonial</th>
							<th class="text-nowrap text-center">Proveedor</th>
							<th class="text-nowrap text-center">Agregar Documento</th>
							<th class="text-nowrap text-center">Eliminar</th>
						</tr>
						@foreach($equipos_data as $index => $equipo_data)
						<tr class="@if($equipo_data->deleted_at) bg-danger @endif">
							<td class="text-nowrap text-center" id="{{$equipo_data->idactivo}}">								
								{{Form::hidden('idactivo_'.$index,$equipo_data->idactivo,array('id'=>'idactivo_'.$index))}}
								{{$index+1}}
							</td>
							<td class="text-nowrap text-center">
								{{$equipo_data->nombre_grupo}}
							</td>
							<td class="text-nowrap text-center">
								{{$equipo_data->nombre_servicio}}
							</td>
							<td class="text-nowrap text-center">
								{{$equipo_data->nombre_equipo}}
							</td>
							<td class="text-nowrap text-center" class="text-nowrap text-center">
								{{$equipo_data->nombre_marca}}
							</td>
							<td class="text-nowrap text-center">
								{{$equipo_data->modelo}}
							</td>
							<td class="text-nowrap text-center">
								{{$equipo_data->codigo_patrimonial}}
							</td>
							<td class="text-nowrap text-center" class="text-nowrap text-center">
								{{$equipo_data->nombre_proveedor}}
							</td>
							<td class="text-nowrap text-center">
								<a href='' class='btn btn-success' onclick='add_modal_documentos(event,{{$equipo_data->idactivo}})'><span class="glyphicon glyphicon-file"> </span> Documentos</a>
							</td>
							<td class=\"text-nowrap text-center\">
								<a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class="glyphicon glyphicon-remove"></span></a>
							</td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/reportes_calibracion/list_reportes_calibracion')}}">Cancelar</a>				
			</div>
			<div class="form-group col-md-3 col-md-offset-5">
				{{ Form::button('<span class="glyphicon glyphicon-trash"></span> Limpiar Resultados', array('id'=>'btnLimpiarResultados', 'class' => 'btn btn-danger btn-block')) }}				
			</div>
		</div>

		<div id="modals">
			@foreach($equipos_data as $index => $equipo)
			<div class="container">
			  <!-- Modal -->
			  <div class="modal fade" id="modal_{{$equipo->idactivo}}" role="dialog" data-backdrop="static" data-keyboard="false">
			    <div class="modal-dialog modal-md">    
			      <!-- Modal content-->
			      <div class="modal-content">
			        <div class="modal-header bg-primary">
			           <h4 class="modal-title">Documentos Adjuntos</h4>
			        </div>
			        <div class="modal-body">
			        	<div class="panel panel-default">
							<div class="panel-heading">
							  <h3 class="panel-title">Documentos</h3>
							</div>
						   <div class="panel-body"> 			        	
					        	@for($i = 0 ; $i < 10 ; $i+=2 )
					        		<div class="row" style="@if($i>1) display:none; @endif" id="div_file_{{$equipo->idactivo}}_{{$i}}" >
					        			<div class="col-md-8 form-group">
					        				{{ Form::label('label_doc',($i+1).') Certificado de Calibración:') }}
											<input name="input-file-{{$equipo->idactivo}}-{{$i}}" id="input-file-{{$equipo->idactivo}}-{{$i}}" type="file" class="file file-loading" data-show-upload="false">
					       				</div>
					       				@if($i>1)
					       				<div class="col-md-2" style="margin-top:25px;">
					       					<a href='' class='btn btn-danger delete-detail' onclick='hide_div(event,{{$equipo_data->idactivo}},{{$i}})'><span class="glyphicon glyphicon-remove"></span></a>
					       				</div>
					       				@endif
					       			</div>
					       			<div class="row" style="@if($i>1) display:none; @endif" id="div_file_{{$equipo->idactivo}}_{{$i+1}}" >
					        			<div class="col-md-8 form-group">
					        				{{ Form::label('label_doc',($i+2).') Reporte de Calibración:') }}
											<input name="input-file-{{$equipo->idactivo}}-{{$i+1}}" id="input-file-{{$equipo->idactivo}}-{{$i+1}}" type="file" class="file file-loading" data-show-upload="false">
					       				</div>
					       				@if($i>1)
					       				<div class="col-md-2" style="margin-top:25px;">
					       					<a href='' class='btn btn-danger delete-detail' onclick='hide_div(event,{{$equipo_data->idactivo}},{{$i+1}})'><span class="glyphicon glyphicon-remove"></span></a>
					       				</div>
					       				@endif
					       			</div>
					       		@endfor					       		
					       	</div>    
					    </div>
					    <div class="row"> 
				       		<div class="form-group col-md-5 col-md-offset-7">
								<a class="btn btn-success btn-block" onclick="show_files(event,{{$equipo->idactivo}})"><span class="glyphicon glyphicon-plus"></span> Agregar Documentos</a>				
							</div>
			       		</div>
					    <div class="panel panel-default">
							<div class="panel-heading">
							  <h3 class="panel-title">Fecha de Calibración</h3>
							</div>
						   <div class="panel-body"> 			        	
					        	<div class="form-group col-md-6">
									{{ Form::label('fecha_calibracion','Fecha de Calibracion') }}
									<div id="fecha_calibracion_datetimepicker" class=" input-group date @if($errors->first('fecha_calibracion')) has-error has-feedback @endif">
										{{ Form::text('fecha_calibracion-'.$equipo->idactivo,Input::old('fecha_calibracion-'.$equipo->idactivo),array('class'=>'form-control','readonly'=>'','id'=>'fecha_calibracion_'.$equipo->idactivo)) }}
										<span class="input-group-addon">
						                    <span class="glyphicon glyphicon-calendar"></span>
						                </span>
									</div>
								</div>
								<div class="form-group col-md-6">
									{{ Form::label('fecha_proximo','Fecha Próxima de Calibración') }}
									<div id="fecha_proximo_datetimepicker" class=" input-group date @if($errors->first('fecha_proximo')) has-error has-feedback @endif">
										{{ Form::text('fecha_proximo-'.$equipo->idactivo,Input::old('fecha_proximo-'.$equipo->idactivo),array('class'=>'form-control','readonly'=>'','id'=>'fecha_proximo_'.$equipo->idactivo)) }}
										<span class="input-group-addon">
						                    <span class="glyphicon glyphicon-calendar"></span>
						                </span>
									</div>
								</div>
					       	</div>    
					    </div>     	
			        </div>
			        <div class="modal-footer">
			        	<div class="row">
		        			<div class="col-md-3 col-md-offset-6">
		       					<button type="button" class="btn btn-primary btn-block" data-container="body" data-placement="top" data-trigger="click" id="btn_close_{{$equipo->idactivo}}" onclick="save_modal({{$equipo->idactivo}})" ><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
		        			</div>		        			
							<div class="form-group col-md-3">
								<a class="btn btn-default btn-block" onclick="close_modal({{$equipo->idactivo}})">Cancelar</a>				
							</div>
			        	</div>
			        </div>
			      </div>      
			    </div>
			  </div>  
			</div>
			@endforeach
		</div>
		<div id="activos_hidden_inputs" style="display:none">
			<?php 
				$details_activos = Input::old('details_activos');			
				$count = count($details_activos);	
			?>	
			<?php for($i=0;$i<$count;$i++){ ?>
				<input style="border:0;" name='details_activos[]' value='{{ $details_activos[$i] }}' readonly/>
			<?php } ?>
		</div>

		<script>
			cantidad_activos = $('#cantidad_activos').val();
			for(i=0;i<cantidad_activos;i++){
				idactivo = $('#idactivo_'+i).val();
				for(j=0;j<10;j++){
					$("#input-file-"+idactivo+"-"+j).fileinput({
					    language: "es",
					    maxFileSize: 15360,
					    allowedFileExtensions: ["png","jpe","jpeg","jpg","pdf","doc","docx","xls","xlsx","ppt","pptx"]
					});
				}
			}
		</script>
	{{ Form::close()}}
@stop