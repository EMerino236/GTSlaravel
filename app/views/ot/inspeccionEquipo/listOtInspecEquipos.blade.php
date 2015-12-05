@extends('templates/otInspeccionEquiposTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Inspección de Equipos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
		<div class="container-fluid form-group row">
			<div class="col-md-4 col-md-offset-8">
				<a class="btn btn-primary btn-block" href="{{URL::to('/inspec_equipos/programacion')}}">
				<span class="glyphicon glyphicon-plus"></span> Agregar Inspección de Equipos</a>
			</div>
		</div>
    {{ Form::open(array('url'=>'/inspec_equipos/search_ot_inspec_equipos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Búsqueda</h3>
				</div>
				<div class="panel-body">
					<div class="container-fluid form-group row">
						<div class="form-group col-md-4">
							{{ Form::label('search_ing','Ingeniero a cargo') }}
							{{ Form::text('search_ing',$search_ing,array('class'=>'form-control','placeholder'=>'Nombre o apellidos','id'=>'search_ing')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ot','Orden de Trabajo de Mantenimiento') }}
							{{ Form::text('search_ot',$search_ot,array('class'=>'form-control','placeholder'=>'Número de OT','id'=>'search_ot')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_servicio','Servicio') }}
							{{ Form::select('search_servicio', array('0' => 'Seleccione') + $servicios ,$search_servicio ,array('class'=>'form-control')) }}
						</div>		
						<div class="form-group col-md-4">
							{{ Form::label('search_equipo','Equipo Relacionado:') }}
							{{ Form::text('search_equipo',$search_equipo,array('class'=>'form-control','placeholder'=>'Nombre del Equipo o Modelo Relacionado','id'=>'search_equipo')) }}
						</div>
			
						<div class="form-group col-md-4">
							{{ Form::label('search_ini','Fecha inicio') }}
							<div id="search_datetimepicker1" class="form-group input-group date">
								{{ Form::text('search_ini',$search_ini,array('class'=>'form-control','readonly'=>'','id'=>'search_ini')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
							</div>
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_fin','Fecha fin') }}
							<div id="search_datetimepicker2" class="input-group date">
								{{ Form::text('search_fin',$search_fin,array('class'=>'form-control','readonly'=>'','id'=>'search_fin')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>					
					</div>
					<div class="container-fluid form-group row">
						<div class="form-group col-md-2 col-md-offset-8">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
						</div>
						<div class="form-group col-md-2">
							<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>					
					</div>
				</div>	
			</div>
		</div>
	</div>
	{{ Form::close() }}	
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Fecha</th>
						<th class="text-nowrap text-center">Departamento</th>
						<th class="text-nowrap text-center">Servicio</th>
						<th class="text-nowrap text-center">Ingeniero</th>
						<th class="text-nowrap text-center">Orden Trabajo Mantenimiento</th>
						<th class="text-nowrap text-center">Estado</th>
						<th class="text-nowrap text-center">Eliminar</th>
					</tr>
					@foreach($inspecciones_equipos_data as $index => $inspeccion_equipo_data)
					{{form::hidden('fila',$inspeccion_equipo_data->idot_inspec_equipo,array('id'=>'fila'.$index))}}
					<tr>
						<td class="text-nowrap text-center">
							{{date('d-m-Y',strtotime($inspeccion_equipo_data->fecha_inicio))}}
						</td>
						<td class="text-nowrap text-center">
							{{$inspeccion_equipo_data->nombre_area}}
						</td>
						<td class="text-nowrap text-center">
							{{$inspeccion_equipo_data->nombre_servicio}}
						</td>
						<td class="text-nowrap text-center">
							{{$inspeccion_equipo_data->apellido_pat}} {{$inspeccion_equipo_data->apellido_mat}}, {{$inspeccion_equipo_data->nombre_user}}
						</td>
						<td class="text-nowrap text-center">
						@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
							@if($inspeccion_equipo_data->idestado!=25)
								<a href="{{URL::to('/inspec_equipos/create_ot_inspeccion_equipos/')}}/{{$inspeccion_equipo_data->idot_inspec_equipo}}">{{$inspeccion_equipo_data->ot_tipo_abreviatura}}{{$inspeccion_equipo_data->ot_correlativo}}{{$inspeccion_equipo_data->ot_activo_abreviatura}}</a>
							@else
								<a href="{{URL::to('/inspec_equipos/view_ot_inspeccion_equipos/')}}/{{$inspeccion_equipo_data->idot_inspec_equipo}}">{{$inspeccion_equipo_data->ot_tipo_abreviatura}}{{$inspeccion_equipo_data->ot_correlativo}}{{$inspeccion_equipo_data->ot_activo_abreviatura}}</a>
							@endif
						@else
							@if($inspeccion_equipo_data->idestado!=25)
								<a href="{{URL::to('/inspec_equipos/view_ot_inspeccion_equipos/')}}/{{$inspeccion_equipo_data->idot_inspec_equipo}}">{{$inspeccion_equipo_data->ot_tipo_abreviatura}}{{$inspeccion_equipo_data->ot_correlativo}}{{$inspeccion_equipo_data->ot_activo_abreviatura}}</a>
							@else
								<a href="{{URL::to('/inspec_equipos/view_ot_inspeccion_equipos/')}}/{{$inspeccion_equipo_data->idot_inspec_equipo}}">{{$inspeccion_equipo_data->ot_tipo_abreviatura}}{{$inspeccion_equipo_data->ot_correlativo}}{{$inspeccion_equipo_data->ot_activo_abreviatura}}</a>
							@endif
						@endif
						</td>					
						<td class="text-nowrap text-center">
							{{$inspeccion_equipo_data->nombre_estado}}
						</td>
						<td class="text-nowrap text-center">
						@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
							@if($inspeccion_equipo_data->idestado!=25)
								<div class="btn btn-danger btn-block" onclick='eliminar_ot(event,this)'><span class="glyphicon glyphicon-trash"></span></div>
							@else
								-
							@endif
						@else
							-
						@endif
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="modal_list_ot" role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" id="modal_list_header_ot">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
        </div>
        <div class="modal-body" id="modal_text_list_ot">         	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="btn_close_modal" data-dismiss="modal">Aceptar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>
	
@stop