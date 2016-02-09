@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Sección de Investigación</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    
    <div class="row">
    	<div class="col-md-8">
	    	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lista de guías pendientes de cargar</h3>
				</div>
				<div class="panel-body">
				<table class="table">
					<tr class="info">
						<th>N°</th>
						<th>Tipo de Guía</th>
						<th>Nombre</th>
						<th>Autor</th>
						<th>Fecha de Creación</th>
					</tr>
					@foreach($documentos_data as $index => $documento_data)
					<tr class="@if($documento_data->deleted_at) bg-danger @endif">
						<td>{{$index + 1}}</td>
						<td>{{$documento_data->nombre_tipo_documento}}</td>
						<td>
							<a href="{{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$documento_data->iddocumentosinf}}">{{$documento_data->nombre}}</a>
						</td>
						<td>
							{{$documento_data->autor}}
						</td>
						<td>
							{{$documento_data->created_at}}
						</td>
					</tr>
					@endforeach
				</table>
				</div>
			</div>
		</div>
		<div class="col-md-4" style="margin-top:50px;">
			<font size=6 color="#337ab7"><i class="fa fa-graduation-cap fa-fw"></i> Investigación</font>
			<p style="text-align:justify;">El módulo de investigación realiza la retroalimentación del software 
				a través de la actualización de formatos usados en los otros módulos así como la gestión de los 
				proyectos de investigación.</p>
		</div>
	</div>
	<div class="row">
    	<div class="col-md-8">
	    	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lista de proyectos en curso</h3>
				</div>
				<div class="panel-body">
					<!--
				    <table class="table">
						<tr class="info">
							<th>N° Reporte</th>
							<th>Fecha y Hora</th>
							<th>Usuario</th>
							<th>Nombre de Equipo</th>
							<th>Servicio Clínico</th>
							<th>Departamento</th>
							<th>OT de Baja de Equipo</th>
						</tr>
					</table>
				-->
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-11" style="margin-top:50px;" align="center">
			<img heigth= "140" width="140" src="{{asset('img')}}/logo_gts.png"/>
			<font size=7 color="#337ab7" style="display:inline-block;margin-top:15px;font-family:'softwareTest';font-weight:bold;"> GTS SOFTWARE </font>
		</div>
	</div>

@stop