$( document ).ready(function(){
	
	init_ot_create();

	

	$("#submit-tarea").click(function(e){
		e.preventDefault;
		if($("input[name=nombre_tarea]").val().length<1){
			$("input[name=nombre_tarea]").parent().addClass("has-error has-feedback");
			alert("Ingrese una tarea válida.");
		}else{
			$("input[name=nombre_tarea]").parent().removeClass("has-error has-feedback");
			if (confirm('¿Está seguro de esta acción?')){
				$.ajax({
					url: inside_url+'mant_preventivo/submit_create_tarea_ajax',
					type: 'POST',
					data: { 
						'idot_preventivo' : $("input[name=idot_preventivo]").val(),
						'nombre_tarea' : $("input[name=nombre_tarea]").val(),
						'idactivo' : $("input[name=idactivo]").val(),
					},
					beforeSend: function(){
						$(this).prop('disabled',true);
					},
					complete: function(){
						$(this).prop('disabled',false);
					},
					success: function(response){
						var str = "";
						str += '<tr id="tarea-row-'+response.otPreventivoxtarea.idtareas_ot_preventivosxot_preventivo+'"><td>'+response.tarea.nombre+'</td>';
						str += '<td><button class="btn btn-danger boton-eliminar-tarea" onclick="eliminar_tarea(event,'+response.otPreventivoxtarea.idtareas_ot_preventivosxot_preventivo+')" type="button">Eliminar</button></td></tr>';
						$("#tareas-table").append(str);
					},
					error: function(){
					}
				});
			}
		}

	});

	$(".boton-tarea").click(function(e){
		idot_preventivo = $('#idot_preventivo').val();
		e.preventDefault;
		if (confirm('¿Está seguro de esta acción?')){
			$.ajax({
				url: inside_url+'mant_preventivo/submit_marcar_tarea_ajax',
				type: 'POST',
				data: { 'idtareas_ot_preventivosxot_preventivo' : $(this).data('id') },
				beforeSend: function(){
				},
				complete: function(){
				},
				success: function(response){
					console.log(response);
					$(this).prop('disabled',true);
					var url = inside_url + "mant_preventivo/create_ot_preventivo/"+idot_preventivo;
					window.location = url;
				},
				error: function(){
				}
			});
		}
	});

	$("#submit-repuesto").click(function(e){
		e.preventDefault;
			var error_str = "";
			var reg = /[^0-9a-bA-B\s]/gi;
			var intRegex = /^\d+$/;
			var floatRegex = /^\d{1,6}(\.\d{0,2}){0,1}$/;
			var is_correct = true;
			$("input[name=nombre_repuesto]").parent().removeClass("has-error has-feedback");
			$("input[name=codigo_repuesto]").parent().removeClass("has-error has-feedback");
			$("input[name=cantidad_repuesto]").parent().removeClass("has-error has-feedback");
			$("input[name=costo_repuesto]").parent().removeClass("has-error has-feedback");
			if(!reg.test($("input[name=nombre_repuesto]").val())){
				error_str += "El nombre debe ser alfanumérico.\n";
				$("input[name=nombre_repuesto]").parent().addClass("has-error has-feedback");
				is_correct = false;
			}
			if($("input[name=nombre_repuesto]").val().length < 1 || $("input[name=nombre_repuesto]").val().length > 200){
				error_str += "El nombre es obligatorio y debe contener menos de 200 caracteres\n";
				$("input[name=nombre_repuesto]").parent().addClass("has-error has-feedback");
				is_correct = false;
			}
			if(!reg.test($("input[name=codigo_repuesto]").val())){
				error_str += "El código debe ser alfanumérico.\n";
				is_correct = false;
				$("input[name=codigo_repuesto]").parent().addClass("has-error has-feedback");
			}
			if($("input[name=codigo_repuesto]").val().length < 1 || $("input[name=codigo_repuesto]").val().length > 45){
				error_str += "El código es obligatorio y debe contener menos de 200 caracteres.\n";
				is_correct = false;
				$("input[name=codigo_repuesto]").parent().addClass("has-error has-feedback");
			}
			if(!intRegex.test($("input[name=cantidad_repuesto]").val()) || $("input[name=cantidad_repuesto]").val().length < 1 || $("input[name=cantidad_repuesto]").val().length > 10){
				error_str += "La cantidad debe ser un número entero.\n";
				is_correct = false;
				$("input[name=cantidad_repuesto]").parent().addClass("has-error has-feedback");
			}
			if(!floatRegex.test($("input[name=costo_repuesto]").val()) || $("input[name=costo_repuesto]").val().length < 1 || $("input[name=costo_repuesto]").val().length > 10){
				error_str += "El costo tiene un formato incorrecto.\n";
				is_correct = false;
				$("input[name=costo_repuesto]").parent().addClass("has-error has-feedback");
			}

			if(is_correct){
				$.ajax({
					url: inside_url+'mant_preventivo/submit_create_repuesto_ajax',
					type: 'POST',
					data: { 
						'idot_preventivo' : $("input[name=idot_preventivo]").val(),
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
						var str = "";
						str += '<tr id="repuesto-row-'+response.repuesto.idrepuestos_ot+'"><td>'+response.repuesto.nombre+'</td>';
						str += "<td>"+response.repuesto.codigo+"</td>";
						str += "<td>"+response.repuesto.cantidad+"</td>";
						str += "<td>"+response.repuesto.costo+"</td>";
						str += '<td><button class="btn btn-danger boton-eliminar-repuesto" onclick="eliminar_repuesto(event,'+response.repuesto.idrepuestos_ot_preventivo+')" type="button">Eliminar</button></td></tr>';
						$("#repuestos-table").append(str);
						$("input[name=costo_total_repuestos]").val(response.costo_total_repuestos);
					},
					error: function(){
					}
				});
			}else{
				$('#modal_text_ot').html('<p>'+error_str+'</p>');
				$('#modal_header_ot').addClass('bg-danger');
            	$('#modal_info_ot').modal('show');    
			}
		
	});


	$("#submit-personal").click(function(e){
		e.preventDefault;
			var error_str = "";
			var reg = /[\w'-]+/;
			var floatRegex = /^\d{1,6}(\.\d{0,2}){0,1}$/;
			var is_correct = true;
			$("input[name=nombre_personal]").parent().removeClass("has-error has-feedback");
			$("input[name=horas_trabajadas]").parent().removeClass("has-error has-feedback");
			$("input[name=costo_personal]").parent().removeClass("has-error has-feedback");
			if(!reg.test($("input[name=nombre_personal]").val())){
				error_str += "El nombre debe ser alfanumérico.\n";
				$("input[name=nombre_personal]").parent().addClass("has-error has-feedback");
				is_correct = false;
			}
			if($("input[name=nombre_personal]").val().length < 1 || $("input[name=nombre_personal]").val().length > 200){
				error_str += "El nombre es obligatorio y debe contener menos de 200 caracteres.\n";
				$("input[name=nombre_personal]").parent().addClass("has-error has-feedback");
				is_correct = false;
			}
			if(!floatRegex.test($("input[name=horas_trabajadas]").val()) || $("input[name=horas_trabajadas]").val().length < 1 || $("input[name=horas_trabajadas]").val().length > 10){
				error_str += "Las horas deben tener un formato fraccionario: 0.5.\n";
				is_correct = false;
				$("input[name=horas_trabajadas]").parent().addClass("has-error has-feedback");
			}
			if(!floatRegex.test($("input[name=costo_personal]").val()) || $("input[name=costo_personal]").val().length < 1 || $("input[name=costo_personal]").val().length > 10){
				error_str += "El costo tiene un formato incorrecto.\n";
				is_correct = false;
				$("input[name=costo_personal]").parent().addClass("has-error has-feedback");
			}
			if(is_correct){
				$.ajax({
					url: inside_url+'mant_preventivo/submit_create_personal_ajax',
					type: 'POST',
					data: { 
						'idot_preventivo' : $("input[name=idot_preventivo]").val(),
						'nombre_personal' : $("input[name=nombre_personal]").val(),
						'horas_trabajadas' : $("input[name=horas_trabajadas]").val(),
						'costo_personal' : $("input[name=costo_personal]").val()
					},
					beforeSend: function(){
						$(this).prop('disabled',true);
					},
					complete: function(){
						$(this).prop('disabled',false);
					},
					success: function(response){
						var str = "";
						str += '<tr id="personal-row-'+response.personal.idpersonal_ot_preventivo+'"><td>'+response.personal.nombre+'</td>';
						str += "<td>"+response.personal.horas_hombre+"</td>";
						str += "<td>"+response.personal.costo+"</td>";
						str += '<td><button class="btn btn-danger boton-eliminar-personal" onclick="eliminar_personal(event,'+response.personal.idpersonal_ot_preventivo+')" type="button">Eliminar</button></td></tr>';
						$("#personal-table").append(str);
						$("input[name=costo_total_personal]").val(response.costo_total_personal);
					},
					error: function(){
					}
				});
			}else{
				$('#modal_text_ot').html('<p>'+error_str+'</p>');
				$('#modal_header_ot').addClass('bg-danger');
            	$('#modal_info_ot').modal('show');   
			}
		
	});
});

function eliminar_repuesto(e,id){
	e.preventDefault();
	if (confirm('¿Está seguro de eliminar el repuesto?')){
		$.ajax({
			url: inside_url+'mant_preventivo/submit_delete_repuesto_ajax',
			type: 'POST',
			data: { 
				'idot_preventivo' : $("input[name=idot_preventivo]").val(),
				'idrepuestos_ot_preventivo' : id,
			},
			beforeSend: function(){
				//$(this).prop('disabled',true);
			},
			complete: function(){
				//$(this).prop('disabled',false);
			},
			success: function(response){
				$("#repuesto-row-"+id).remove();
				$("input[name=costo_total_repuestos]").val(response.costo_total_repuestos);
			},
			error: function(){
			}
		});
	}
}

function init_ot_create(){
	array_fecha = $('#fecha_programacion_ot').val().split('-');
	fecha_str = array_fecha[2]+"-"+array_fecha[1]+"-"+array_fecha[0];
	$("#datetimepicker_conformidad_fecha").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY',
		sideBySide: true,
		minDate: fecha_str
	});
	$('#fecha_conformidad').val('');
	
	$("#datetimepicker_conformidad_hora").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'HH:ss',
		sideBySide: true
	});

	$("#datetimepicker_fecha_inicio_ot").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});

	$("#datetimepicker_fecha_fin_ot").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});
}

function eliminar_personal(e,id){
	e.preventDefault();
	if (confirm('¿Está seguro de eliminar el personal de la OT?')){
		$.ajax({
			url: inside_url+'mant_preventivo/submit_delete_personal_ajax',
			type: 'POST',
			data: { 
				'idot_preventivo' : $("input[name=idot_preventivo]").val(),
				'idpersonal_ot_preventivo' : id,
			},
			beforeSend: function(){
				//$(this).prop('disabled',true);
			},
			complete: function(){
				//$(this).prop('disabled',false);
			},
			success: function(response){
				$("#personal-row-"+id).remove();
				$("input[name=costo_total_personal]").val(response.costo_total_personal);
			},
			error: function(){
			}
		});
	}
}

function eliminar_tarea_preventivo(e,id){
	idot_preventivo = $('#idot_preventivo').val();
	e.preventDefault();
	if (confirm('¿Está seguro de eliminar la tarea?')){
		$.ajax({
			url: inside_url+'mant_preventivo/submit_delete_tarea_ajax',
			type: 'POST',
			data: { 
				'idtareas_ot_preventivosxot_preventivo' : id,
			},
			beforeSend: function(){
				//$(this).prop('disabled',true);
			},
			complete: function(){
				//$(this).prop('disabled',false);
			},
			success: function(response){
				$("#tarea-row-"+id).remove();
				var url = inside_url + "mant_preventivo/create_ot_preventivo/"+idot_preventivo;
				window.location = url;
			},
			error: function(){
			}
		});
	}
}