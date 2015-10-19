$( document ).ready(function(){

	$("#datetimepicker3").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});

	$(".datetimepicker").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});

	var idactivo = $("input[name=idactivo]").val();
	$.ajax({
		url: inside_url+'mant_correctivo/calendario_ot_mant_correctivo',
		type: 'POST',
		data: { 'idactivo' : idactivo },
		beforeSend: function(){
		},
		complete: function(){
		},
		success: function(response){
			var programaciones = {};
			for(var i=0;i<response.programaciones.length;i++){
				var prog = response.programaciones[i];
				programaciones[prog] = {};
			}
			console.log(response);
			console.log(programaciones);
			initialize_calendar(programaciones);
		},
		error: function(){
		}
	});

	$(".boton-tarea").click(function(e){
		e.preventDefault;
		if (confirm('¿Está seguro de esta acción?')){
			console.log($(this).data('id'));
			$.ajax({
				url: inside_url+'marcar_tarea/submit_marcar_tarea_ajax',
				type: 'POST',
				data: { 'idotxactxta' : $(this).data('id') },
				beforeSend: function(){
				},
				complete: function(){
				},
				success: function(response){
					console.log(response);
					$(this).prop('disabled',true);
				},
				error: function(){
				}
			});
		}
	});

	$("#submit-repuesto").click(function(e){
		e.preventDefault;
		console.log($("input[name=idorden_trabajoxactivo]").val());
		console.log($("input[name=nombre_repuesto]").val());
		console.log($("input[name=codigo_repuesto]").val());
		console.log($("input[name=cantidad_repuesto]").val());
		console.log($("input[name=costo_repuesto]").val());
		if (confirm('¿Está seguro de esta acción?')){
			$.ajax({
				url: inside_url+'mant_correctivo/submit_create_repuesto_ajax',
				type: 'POST',
				data: { 
					'idorden_trabajoxactivo' : $("input[name=idorden_trabajoxactivo]").val(),
					'nombre_repuesto' : $("input[name=nombre_repuesto]").val(),
					'codigo_repuesto' : $("input[name=codigo_repuesto]").val(),
					'cantidad_repuesto' : $("input[name=cantidad_repuesto]").val(),
					'costo_repuesto' : $("input[name=costo_repuesto]").val()
				},
				beforeSend: function(){
					$(this).prop('disabled',true);
				},
				complete: function(){
					$(this).prop('disabled',false);
				},
				success: function(response){
					console.log(response);
				},
				error: function(){
				}
			});
		}
	});

	$(".boton-eliminar-repuesto").click(function(e){
		e.preventDefault;
		if (confirm('¿Está seguro de esta acción?')){
			console.log($(this).data('id'));
			$.ajax({
				url: inside_url+'marcar_tarea/submit_marcar_tarea_ajax',
				type: 'POST',
				data: { 'idotxactxta' : $(this).data('id') },
				beforeSend: function(){
				},
				complete: function(){
				},
				success: function(response){
					console.log(response);
					$(this).prop('disabled',true);
				},
				error: function(){
				}
			});
		}
	});
    
});


function initialize_calendar(programaciones){
	$('.responsive-calendar').responsiveCalendar({
    	translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
    	events: programaciones,
    });
}