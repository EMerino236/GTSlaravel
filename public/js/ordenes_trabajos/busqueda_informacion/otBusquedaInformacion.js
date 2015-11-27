$( document ).ready(function(){
	
	init_ot_create();

	
	$("#submit-tarea").click(function(e){
		idot_busqueda_info = $('#idot_busqueda_info').val();
		e.preventDefault;
		if($("input[name=nombre_tarea]").val().length<1){
			$("input[name=nombre_tarea]").parent().addClass("has-error has-feedback");
			alert("Ingrese una tarea válida.");
		}else{
			$("input[name=nombre_tarea]").parent().removeClass("has-error has-feedback");
			BootstrapDialog.confirm({
					title: 'Mensaje de Confirmación',
					message: '¿Está seguro que desea realizar esta acción?', 
					type: BootstrapDialog.TYPE_INFO,
					btnCancelLabel: 'Cancelar', 
	            	btnOKLabel: 'Aceptar', 
					callback: function(result){
			            if(result) {
			                $.ajax({
								url: inside_url+'busqueda_informacion/submit_create_tarea_ajax',
								type: 'POST',
								data: { 
									'idot_busqueda_info' : $("input[name=idot_busqueda_info]").val(),
									'nombre_tarea' : $("input[name=nombre_tarea]").val()
								},
								beforeSend: function(){
									$(this).prop('disabled',true);
								},
								complete: function(){
									$(this).prop('disabled',false);
								},
								success: function(response){
									/*var str = "";
									str += '<tr id="tarea-row-'+response.tarea.idtareas_ot_busqueda_info+'"><td>'+response.tarea.nombre+'</td>';
									str += '<td><button class="btn btn-default boton-tarea" data-id=\"'+ response.tarea.idtareas_ot_busqueda_info+'\" type="button">Marcar Realizada</button></td>';
									str += '<td><button class="btn btn-danger boton-eliminar-tarea" onclick="eliminar_tarea(event,'+response.tarea.idtareas_ot_busqueda_info+')" type="button">Eliminar</button></td></tr>';
									$("#tareas-table").append(str);*/
									var url = inside_url + "busqueda_informacion/create_ot_busqueda_informacion/"+idot_busqueda_info;
									window.location = url;
								},
								error: function(){
								}
							});
	            		}
	        		}
			});
		}
	});

	$(".boton-tarea").click(function(e){
		e.preventDefault;	
		idtareas_ot_busqueda_info = $(this).data('id');
		idot_busqueda_info = $('#idot_busqueda_info').val();		
		BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
        	btnOKLabel: 'Aceptar', 
			callback: function(result){
	            if(result) {	            	
	                $.ajax({
						url: inside_url+'busqueda_informacion/submit_marcar_tarea_ajax',
						type: 'POST',
						data: { 'idtareas_ot_busqueda_info' : idtareas_ot_busqueda_info },
						beforeSend: function(){
						},
						complete: function(){
						},
						success: function(response){
							console.log(response);
							$(this).prop('disabled',true);
							var url = inside_url + "busqueda_informacion/create_ot_busqueda_informacion/"+idot_busqueda_info;
							window.location = url;
						},
						error: function(){
						}
					});
        		}
    		}
		});
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
				BootstrapDialog.confirm({
					title: 'Mensaje de Confirmación',
					message: '¿Está seguro que desea realizar esta acción?', 
					type: BootstrapDialog.TYPE_INFO,
					btnCancelLabel: 'Cancelar', 
	            	btnOKLabel: 'Aceptar', 
					callback: function(result){
			            if(result) {
							$.ajax({
								url: inside_url+'busqueda_informacion/submit_create_personal_ajax',
								type: 'POST',
								data: { 
									'idot_busqueda_info' : $("input[name=idot_busqueda_info]").val(),
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
									str += '<tr id="personal-row-'+response.personal.idpersonal_ot_busqueda_info+'"><td>'+response.personal.nombre+'</td>';
									str += "<td>"+response.personal.horas_hombre+"</td>";
									str += "<td>"+response.personal.costo+"</td>";
									str += '<td><button class="btn btn-danger boton-eliminar-personal" onclick="eliminar_personal(event,'+response.personal.idpersonal_ot_busqueda_info+')" type="button">Eliminar</button></td></tr>';
									$("#personal-table").append(str);
									$("input[name=costo_total_personal]").val(response.costo_total_personal);
								},
								error: function(){
								}
							});
						}
					}
				});
			}else{
				$('#modal_text_ot').html('<p>'+error_str+'</p>');
				$('#modal_header_ot').addClass('bg-danger');
            	$('#modal_info_ot').modal('show');   
			}
		
	});
});

function init_ot_create(){
	array_fecha = $('#fecha_programacion_ot').val().split('-');
	fecha_str = array_fecha[2]+"-"+array_fecha[1]+"-"+array_fecha[0];
	$("#datetimepicker_conformidad_fecha").datetimepicker({
		useCurrent: false,
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY',
		sideBySide: true,
		minDate: fecha_str
	});
	
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
	BootstrapDialog.confirm({
		title: 'Mensaje de Confirmación',
		message: '¿Está seguro que desea realizar esta acción?', 
		type: BootstrapDialog.TYPE_DANGER,
		btnCancelLabel: 'Cancelar', 
    	btnOKLabel: 'Aceptar', 
		callback: function(result){
            if(result) {
                $.ajax({
					url: inside_url+'busqueda_informacion/submit_delete_personal_ajax',
					type: 'POST',
					data: { 
						'idot_busqueda_info' : $("input[name=idot_busqueda_info]").val(),
						'idpersonal_ot_busqueda_info' : id,
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
	});
	
}

function eliminar_tarea(e,id){
	idot_busqueda_info = $('#idot_busqueda_info').val();
	e.preventDefault();
	BootstrapDialog.confirm({
		title: 'Mensaje de Confirmación',
		message: '¿Está seguro que desea realizar esta acción?', 
		type: BootstrapDialog.TYPE_DANGER,
		btnCancelLabel: 'Cancelar', 
    	btnOKLabel: 'Aceptar', 
		callback: function(result){
            if(result) {
            	$.ajax({
					url: inside_url+'busqueda_informacion/submit_delete_tarea_ajax',
					type: 'POST',
					data: { 
						'idtareas_ot_busqueda_info' : id,
					},
					beforeSend: function(){
						//$(this).prop('disabled',true);
					},
					complete: function(){
						//$(this).prop('disabled',false);
					},
					success: function(response){
						$("#tarea-row-"+id).remove();
						//var url = inside_url + "busqueda_informacion/create_ot_busqueda_informacion/"+idot_busqueda_info;
						//window.location = url;
					},
					error: function(){
					}
				});
			}
		}
	});	
}