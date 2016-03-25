@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Programacion de docente para capacitación</h3>
        </div>
    </div>

    @if ($errors->has())
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		@foreach($errors->all() as $error)
			<p><strong>{{ $error }}</strong></p>
		@endforeach	
	</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	
	{{ Form::open(array('route'=>['programacion_docente.update',$programacion->id], 'role'=>'form','id'=>'form')) }}
	    <div class="row">
	    	<div class="col-md-8">
				<div class="panel panel-default">
				  	<div class="panel-heading">Datos de la Programación</div>
				  	<div class="panel-body">	
						<div class="row">
							<div class="form-group col-md-6 @if($errors->first('nombre')) has-error has-feedback @endif">
								{{ Form::label('nombre','Nombre de capacitación') }}
								{{ Form::text('nombre', $programacion->nombre,['id'=>'nombre','class'=>'form-control'])}}
							</div>

							<div class="form-group col-md-6 @if($errors->first('departamento')) has-error has-feedback @endif">
								{{ Form::label('departamento','Departamento') }}
								{{ Form::select('departamento', $departamentos, $programacion->id_departamento, ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)']) }}
							</div>

							<div class="form-group col-md-6 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
								{{ Form::label('servicio_clinico','Servicio Clínico') }}
								{{ Form::select('servicio_clinico', $servicios, $programacion->id_servicio_clinico, ['id'=>'servicio_clinico','class'=>'form-control']) }}
							</div>

							<div class="form-group col-md-6 @if($errors->first('numero_sesion')) has-error has-feedback @endif">
								{{ Form::label('numero_sesion','N° Sesión') }}
								{{ Form::select('numero_sesion', $sesiones, $programacion->id_sesion,['id'=>'numero_sesion','class'=>'form-control'])}}
							</div>
						</div>

						<div class="row">
							<div class="form-group col-md-6 @if($errors->first('responsable')) has-error has-feedback @endif">
								{{ Form::label('responsable','Responsable') }}
								{{ Form::select('responsable',$nombres, $programacion->id_responsable,['id'=>'responsable','class'=>'form-control'])}}
							</div>
						</div>
				    </div>				    
				</div>
			</div>

			<script type="text/javascript">
				var dias = {{$dias}};
			</script>
			
			<div class="col-md-4">
				<h3 class="text-center">Programaciones del mes</h3>
				<!-- Responsive calendar - START -->
				<div class="responsive-calendar">
				  <div class="controls">			     
				      <!--<a class="pull-left" data-go="prev"><div class="btn"><i class="glyphicon glyphicon-chevron-left"></i></div></a>-->
				      <h4><span data-head-year></span> <span data-head-month></span></h4>
				      <!--<a class="pull-right" data-go="next"><div class="btn"><i class="glyphicon glyphicon-chevron-right"></i></div></a>-->
				  </div><hr/>
				  <div class="day-headers">
				    <div class="day header">Lun</div>
				    <div class="day header">Mar</div>
				    <div class="day header">Mie</div>
				    <div class="day header">Jue</div>
				    <div class="day header">Vie</div>
				    <div class="day header">Sab</div>
				    <div class="day header">Dom</div>
				  </div>
				  <div class="days" data-group="days">
				    <!-- the place where days will be generated -->
				  </div>
				</div>
				<!-- Responsive calendar - END -->
			</div>
		</div>


		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('type'=>'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2 col-md-offset-8">
				<a class="btn btn-default btn-block" href="{{route('programacion_docente.show',$programacion->id)}}">Cancelar</a>				
			</div>
		</div>
	{{ Form::close()}}

	<div class="container" >
	  <!-- Modal -->
		<div class="modal fade" id="modal_ot"  role="dialog">
		    <div class="modal-dialog modal-md">
		      <!-- Modal content-->
		      <div class="modal-content" >
		        <div class="modal-header" id="modal_header_ot">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title">Capacitaciones</h4>
		        </div>
		        <div class="modal-body" id="modal_text_ot">
		         	
		        </div>
		        <div class="modal-footer">
		        	<button type="button" class="btn btn-default" id="btn_close_modal_confirm" data-dismiss="modal">Aceptar</button>
		        </div>
		      </div>      
		    </div>
		</div>  
	</div>

@stop

<script type="text/javascript">
	window.onload = function() {
        getNumeroInternados();
        $('.responsive-calendar').responsiveCalendar({
	      	translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
	        events:dias,
	        onActiveDayClick: function(events) {
		        var $today, $dayEvents, $i, $isHoveredOver, $placeholder, $output;
		        $i = $(this).data('year')+'-'+zero($(this).data('month'))+'-'+zero($(this).data('day'));
		        $today= events[$i];
		        $dayEvents = $today.dayEvents;
		        $output = '<div class="responsive-calendar-modal">';
		        $.each($dayEvents, function() {
		       		$.each( $(this), function( key ){
			            $("#modal_text_ot").empty();    
			            $('#modal_ot').modal('show');
			            $('#modal_header_ot').removeClass();
			            $('#modal_header_ot').addClass("modal-header ");
			            $('#modal_header_ot').addClass("bg-info");
			            url =  inside_url+'programacion_docente/show/'+$(this)[key].id;
			            $output += '<p>Nombre: <a href="'+url+'" target="_blank">'+$(this)[key].nombre+'</a></p>';
			            $('#modal_text_ot').append($output);
		        	});
		        });
	        },
	    });
    };
</script>