@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Especificaciones Técnicas</h3>            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/especificacion_tecnica/search_especificacion_tecnica','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_familia_activo','Nombre de Equipo:')}}
						<select id="search_familia_activo" name="search_familia_activo" class="form-control">
							<option value="">Seleccione</option>  
						    <?php foreach($familia_activos as $index => $familia_activo){ ?>
			                    <option <?php if(Input::old("search_familia_activo") == $familia_activo['nombre_equipo']){echo("selected");} ?>><?php echo $familia_activo['nombre_equipo']; ?></option> 
						    <?php } ?>	 					   
    					</select> 
					</div>				
				</div>
				<div class="col-md-12">
					<div class="col-md-12">
					<div class="form-group col-md-2 col-md-offset-10">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
					</div>
					<!--
					<div class="form-group col-md-2">
						<div class="btn btn-default btn-block" id="btnLlimpiar_criterios_list_especificacion_tecnica"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>
				-->
				</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>
	<div class="form-group col-md-12">
		@if($search_familia_activo==null)
			<strong><font size="3">Especificaciones Anteriores</font></strong>							
		@else
			<strong><font size="3">Especificaciones Anteriores del equipo {{$search_familia_activo}}</font></strong>							
		@endif
	</div>
	<table class="table">
		<tr class="info">
			<th>Código de Compra</th>
			<th>Término de Referencia</th>
			<th>Fecha</th>
			<th>Servicio Clínico</th>
			<th>Departamento</th>
		</tr>
		@foreach($expedientes_tecnico_data as $expediente_tecnico_data)
		<tr class="@if($expediente_tecnico_data->deleted_at) bg-danger @endif">
			<td>
				@if($user->id == $expediente_tecnico_data->idresponsable || $user->id == $expediente_tecnico_data->idpresidente)
					<a href="{{URL::to('/expediente_tecnico/edit_expediente_tecnico/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}">{{$expediente_tecnico_data->codigo_compra}}</a>
				@else
					<a href="{{URL::to('/expediente_tecnico/view_expediente_tecnico/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}">{{$expediente_tecnico_data->codigo_compra}}</a>
				@endif
			</td>
			<td>
				<a class="btn btn-primary btn-block" href="{{URL::to('/expediente_tecnico/download_tdr/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
			</td>
			<td>
				{{date('d-m-Y H:i',strtotime($expediente_tecnico_data->created_at))}}
			</td>
			<td>
				{{$expediente_tecnico_data->nombre_servicio}}
			</td>
			<td>
				{{$expediente_tecnico_data->nombre_area}}
			</td>
		</tr>
		@endforeach
	</table>
	<hr />
	<div class="panel panel-default">
		<div class="panel-heading">
			@if($search_familia_activo==null)
				<h3 class="panel-title">Especificaciones de acuerdo a MINSA</h3>						
			@else
				<h3 class="panel-title">Especificaciones de acuerdo a MINSA del equipo {{$search_familia_activo}}</h3>						
			@endif
		</div>
		<div class="panel-body">
			@foreach($tipos_especificacion_tecnica as $index => $tipo_especificacion_tecnica)
				<div class="row">
					<div class="form-group col-md-8">
						<strong><font size="2">{{$index+1}}. {{$tipo_especificacion_tecnica->nombre}}</font></strong>							
					</div>
				</div>
				@foreach($especificaciones_tecnica as $index_especificacion => $especificacion_tecnica)
					@if($tipo_especificacion_tecnica->idtipo_especificacion_tecnica == $especificacion_tecnica->idtipo_especificacion_tecnica)
						<div class="row">
							<div class="form-group col-md-12">
								<font size="2">&nbsp;&nbsp;&nbsp;{{$index+1}}.{{$especificacion_tecnica->correlativo_por_tipo_especificacion}} {{$especificacion_tecnica->nombre}}</font>
							</div>
						</div>
					@endif	
				@endforeach
			@endforeach	
		</div>
	</div>
	<div class="form-group col-md-2">
		<a class="btn btn-primary btn-block" href="{{URL::to('/especificacion_tecnica/list_archivos_ECRI/')}}"><span class="glyphicon glyphicon-file"></span> Archivos ECRI</a>
	</div>
	<div class="row">
		@if($search_familia_activo)
			{{ $expedientes_tecnico_data->appends(array('search_familia_activo'=>$search_familia_activo))->links() }}
		@else
			{{ $expedientes_tecnico_data->links() }}
		@endif
	</div>

@stop