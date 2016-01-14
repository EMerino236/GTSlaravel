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

    $('#btnLimpiar').click(function(){
        limpiar_criterios();
    })

    var hoy = new Date();
    var ayer = new Date();
    ayer.setDate(hoy.getDate()-1);
	$(".fecha-hora").datetimepicker({
	    useCurrent: false,
	    defaultDate: false,
	    format: 'DD-MM-YYYY HH:ss',
	    ignoreReadonly: true,
	    //minDate: ayer,
	    //disabledDates: [ayer]
	});

	var alphanumeric_pattern = /[^á-úÁ-Úa-zA-ZñÑüÜ0-9- _.]/;

	$("#submit-tarea").click(function(e){
		e.preventDefault;
		if($("input[name=nombre_tarea]").val().length <1 || $("input[name=nombre_tarea]").val().length >100  || alphanumeric_pattern.test($("input[name=nombre_tarea]").val())){
			$("input[name=nombre_tarea]").parent().addClass("has-error has-feedback");
			dialog = BootstrapDialog.show({
	            title: 'Advertencia',
	            message: 'Ingrese una tarea válida',
	            type : BootstrapDialog.TYPE_DANGER,
	            buttons: [{
	                label: 'Aceptar',
	                action: function(dialog) {
	                    dialog.close();
	                }
	            }]
       		});
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
							url: inside_url+'retiro_servicio/submit_create_tarea_ajax',
							type: 'POST',
							data: { 
								'idot_retiro' : $("input[name=idot_retiro]").val(),
								'nombre_tarea' : $("input[name=nombre_tarea]").val(),
							},
							beforeSend: function(){
								$(this).prop('disabled',true);
							},
							complete: function(){
								$(this).prop('disabled',false);
								$("input[name=nombre_tarea]").val("");
							},
							success: function(response){
								var str = "";
								str += '<tr id="tarea-row-'+response.tarea.idtareas_ot_correctivo+'"><td class=\"text-nowrap\">'+response.tarea.nombre+'</td>';
								str += '<td class=\"text-nowrap text-center\"><button class="btn btn-danger boton-eliminar-tarea" onclick="eliminar_tarea(event,'+response.tarea.idtareas_ot_correctivo+')" type="button"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
								$("#tareas-table").append(str);
							},
							error: function(){
							}
						});
			        }
			    }
			});
		}
	});

	$("#submit-personal").click(function(e){
		e.preventDefault;
		BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
				callback: function(result){
			        if(result) {
			        	var error_str = "Errores:\n";
						var reg = /[^á-úÁ-Úa-zA-ZA]+$/;
						var floatRegex = /^\d{1,6}(\.\d{0,2}){0,1}$/;
						var is_correct = true;
						$("input[name=nombre_personal]").parent().removeClass("has-error has-feedback");
						$("input[name=horas_trabajadas]").parent().removeClass("has-error has-feedback");
						$("input[name=costo_personal]").parent().removeClass("has-error has-feedback");
						if(reg.test($("input[name=nombre_personal]").val())){
							error_str += "El nombre debe ser alfanumérico\n";
							$("input[name=nombre_personal]").parent().addClass("has-error has-feedback");
							is_correct = false;
						}
						if($("input[name=nombre_personal]").val().length < 1 || $("input[name=nombre_personal]").val().length > 200){
							error_str += "El nombre es obligatorio y debe contener menos de 200 caracteres\n";
							$("input[name=nombre_personal]").parent().addClass("has-error has-feedback");
							is_correct = false;
						}
						if(!floatRegex.test($("input[name=horas_trabajadas]").val()) || $("input[name=horas_trabajadas]").val().length < 1 || $("input[name=horas_trabajadas]").val().length > 10){
							error_str += "Las horas deben tener un formato fraccionario: 0.5\n";
							is_correct = false;
							$("input[name=horas_trabajadas]").parent().addClass("has-error has-feedback");
						}
						if(!floatRegex.test($("input[name=costo_personal]").val()) || $("input[name=costo_personal]").val().length < 1 || $("input[name=costo_personal]").val().length > 10){
							error_str += "El costo tiene un formato incorrecto\n";
							is_correct = false;
							$("input[name=costo_personal]").parent().addClass("has-error has-feedback");
						}
						if(is_correct){
							$.ajax({
								url: inside_url+'retiro_servicio/submit_create_personal_ajax',
								type: 'POST',
								data: { 
									'idot_retiro' : $("input[name=idot_retiro]").val(),
									'nombre_personal' : $("input[name=nombre_personal]").val(),
									'horas_trabajadas' : $("input[name=horas_trabajadas]").val(),
									'costo_personal' : $("input[name=costo_personal]").val()
								},
								beforeSend: function(){
									$(this).prop('disabled',true);
								},
								complete: function(){
									$(this).prop('disabled',false);
									$("input[name=nombre_personal]").val("");
									$("input[name=horas_trabajadas]").val("");
									$("input[name=costo_personal]").val("");
								},
								success: function(response){
									var str = "";
									str += '<tr id="personal-row-'+response.personal.idpersonal_ot_correctivo+'"><td class=\"text-nowrap\">'+response.personal.nombre+'</td>';
									str += "<td class=\"text-nowrap text-center\">"+response.personal.horas_hombre+"</td>";
									str += "<td class=\"text-nowrap text-center\">"+response.personal.costo+"</td>";
									str += '<td class=\"text-nowrap text-center\"><button class="btn btn-danger boton-eliminar-personal" onclick="eliminar_personal(event,'+response.personal.idpersonal_ot_correctivo+')" type="button"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
									$("#personal-table").append(str);
									$("input[name=costo_total_personal]").val(response.costo_total_personal);
								},
								error: function(){
								}
							});
						}else{
							dialog = BootstrapDialog.show({
					            title: 'Advertencia',
					            message: error_str,
					            type : BootstrapDialog.TYPE_DANGER,
					            buttons: [{
					                label: 'Aceptar',
					                action: function(dialog) {
					                    dialog.close();
					                }
					            }]
				       		});
						}		
			        }
			    }
			});
	});

	$('#submit_ot').click(function(){
		BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?\n (Si el campo "Equipo no Intervenido" no se encuentra en estado pendiente, la presente ficha no podrá volver a ser editada)', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
			callback: function(result){
		        if(result) {
		        	document.getElementById('submit_ot_retiro').submit();
		        }
		    }
	    });
	});
});

function eliminar_tarea(e,id){
	e.preventDefault();
	BootstrapDialog.confirm({
		title: 'Mensaje de Confirmación',
		message: '¿Está seguro que desea realizar esta acción?', 
		type: BootstrapDialog.TYPE_INFO,
		btnCancelLabel: 'Cancelar', 
    	btnOKLabel: 'Aceptar', 
		callback: function(result){
	        if(result) {
	        	$.ajax({
					url: inside_url+'retiro_servicio/submit_delete_tarea_ajax',
					type: 'POST',
					data: { 
						'idtareas_ot_retiro' : id,
					},
					beforeSend: function(){
						//$(this).prop('disabled',true);
					},
					complete: function(){
						//$(this).prop('disabled',false);
					},
					success: function(response){
						$("#tarea-row-"+id).remove();
					},
					error: function(){
					}
				});
	        }
	    }
	});
}

function eliminar_personal(e,id){
	e.preventDefault();
	BootstrapDialog.confirm({
		title: 'Mensaje de Confirmación',
		message: '¿Está seguro que desea realizar esta acción?', 
		type: BootstrapDialog.TYPE_INFO,
		btnCancelLabel: 'Cancelar', 
    	btnOKLabel: 'Aceptar', 
		callback: function(result){
	        if(result) {
	        	$.ajax({
					url: inside_url+'retiro_servicio/submit_delete_personal_ajax',
					type: 'POST',
					data: { 
						'idot_retiro' : $("input[name=idot_retiro]").val(),
						'idpersonal_ot_retiro' : id,
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