@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Documentos para Plan Director</h3>           
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/plan_director/search_documento_plan_director','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_tipo_documento','Tipo de Reporte:')}}
						{{ Form::select('search_tipo_documento',array('' => 'Seleccione')+$tipo_documento, $search_tipo_documento,array('class'=>'form-control')) }}
					</div>				
					<div class="form-group col-md-4">
						{{ Form::label('search_fecha_ini','Fecha inicio') }}
						<div id="datetimepicker_search_anho1" class="form-group input-group date">
							{{ Form::text('search_fecha_ini',$search_fecha_ini,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_fecha_fin','Fecha fin') }}
						<div id="datetimepicker_search_anho2" class="input-group date">
							{{ Form::text('search_fecha_fin',$search_fecha_fin,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group col-md-2 col-md-offset-8">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
					</div>
					<div class="form-group col-md-2">
						<div class="btn btn-default btn-block" id="btnLlimpiar_criterios_list_documentos"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>
	<div class="container-fluid form-group row">
		<div class="col-md-3 col-md-offset-9">
			<a class="btn btn-primary btn-block" href="{{URL::to('/plan_director/create_documento_plan_director')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar Documento</a>
		</div>
	</div>
	<table class="table">
		<tr class="info">
			<th>Nombre</th>
			<th>Tipo</th>
			<th>Anho</th>
		</tr>
		@foreach($plan_director_data as $documento_plan_director_data)
		<tr class="@if($documento_plan_director_data->deleted_at) bg-danger @endif">
			<td>
				@if($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
					<a href="{{URL::to('/plan_director/edit_documento_plan_director/')}}/{{$documento_plan_director_data->iddocumentosPlanDirector}}">{{$documento_plan_director_data->nombre}}</a>
				@endif
				@if($user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9 || $user->idrol == 10 || $user->idrol == 11 || $user->idrol == 12)
					<a href="{{URL::to('/plan_director/view_documento_plan_director/')}}/{{$documento_plan_director_data->iddocumentosPlanDirector}}">{{$documento_plan_director_data->nombre}}</a>
				@endif
			</td>
			<td>
				{{$documento_plan_director_data->tipo_documento}}
			</td>
			<td>
				{{$documento_plan_director_data->anho}}
			</td>		
		</tr>
		@endforeach
	</table>
	<div class="row">
		@if($search_tipo_documento || $search_fecha_ini || $search_fecha_fin)
			{{ $plan_director_data->appends(array('search_tipo_documento' => $search_tipo_documento,'search_fecha_ini'=>$search_fecha_ini,'search_fecha_fin'=>$search_fecha_fin))->links() }}
		@else
			{{ $plan_director_data->links() }}
		@endif
	</div>
@stop