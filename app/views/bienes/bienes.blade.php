@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Sección de gestión de bienes</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    
    <div class="row">
    	<div class="col-md-8">
	    	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lista de SOTs que no se han programado como OTM Correctivo</h3>
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
		<div class="col-md-4" style="margin-top:50px;">
			<font size=6 color="#337ab7"><i class="fa fa-wrench fa-fw"></i> Bienes</font>
			<p style="text-align:justify;">El módulo de bienes permite realizar el ingreso, mantenimiento y baja de 
				bienes en el sistema. De la misma forma este módulo administra información de soporte a los procesos 
				relacionados.</p>
		</div>
	</div>
	<div class="row">
    	<div class="col-md-8">
	    	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lista de OTM pendientes</h3>
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