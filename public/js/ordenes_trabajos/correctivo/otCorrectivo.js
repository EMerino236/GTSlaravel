
$( document ).ready(function(){
	
	init_ot_correctivo();
	var alphanumeric_pattern = /[^á-úÁ-Úa-zA-ZñÑüÜ0-9- ._]/;
	
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
								url: inside_url+'mant_correctivo/submit_create_tarea_ajax',
								type: 'POST',
								data: { 
									'idot_correctivo' : $("input[name=idot_correctivo]").val(),
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

	$("#submit-repuesto").click(function(e){
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
						var reg_nombre_repuesto =  /[^á-úÁ-Úa-zA-ZñÑüÜ0-9- _]/;
						var reg_codigo_repuesto = /[^á-úÁ-Úa-zA-ZñÑüÜ0-9- _]/;
						var intRegex = /^\d+$/;
						var floatRegex = /^\d{1,6}(\.\d{0,2}){0,1}$/;
						var is_correct = true;
						$("input[name=nombre_repuesto]").parent().removeClass("has-error has-feedback");
						$("input[name=codigo_repuesto]").parent().removeClass("has-error has-feedback");
						$("input[name=cantidad_repuesto]").parent().removeClass("has-error has-feedback");
						$("input[name=costo_repuesto]").parent().removeClass("has-error has-feedback");
						if(reg_nombre_repuesto.test($("input[name=nombre_repuesto]").val())){
							error_str += "El nombre debe ser alfanumérico\n";
							$("input[name=nombre_repuesto]").parent().addClass("has-error has-feedback");
							is_correct = false;
						}
						if($("input[name=nombre_repuesto]").val().length < 1 || $("input[name=nombre_repuesto]").val().length > 200){
							error_str += "El nombre es obligatorio y debe contener menos de 200 caracteres\n";
							$("input[name=nombre_repuesto]").parent().addClass("has-error has-feedback");
							is_correct = false;
						}
						if(reg_codigo_repuesto.test($("input[name=codigo_repuesto]").val())){
							error_str += "El código debe ser alfanumérico\n";
							is_correct = false;
							$("input[name=codigo_repuesto]").parent().addClass("has-error has-feedback");
						}
						if($("input[name=codigo_repuesto]").val().length < 1 || $("input[name=codigo_repuesto]").val().length > 45){
							error_str += "El código es obligatorio y debe contener menos de 200 caracteres\n";
							is_correct = false;
							$("input[name=codigo_repuesto]").parent().addClass("has-error has-feedback");
						}
						if(!intRegex.test($("input[name=cantidad_repuesto]").val()) || $("input[name=cantidad_repuesto]").val().length < 1 || $("input[name=cantidad_repuesto]").val().length > 10){
							error_str += "La cantidad debe ser un número entero\n";
							is_correct = false;
							$("input[name=cantidad_repuesto]").parent().addClass("has-error has-feedback");
						}
						if(!floatRegex.test($("input[name=costo_repuesto]").val()) || $("input[name=costo_repuesto]").val().length < 1 || $("input[name=costo_repuesto]").val().length > 10){
							error_str += "El costo tiene un formato incorrecto\n";
							is_correct = false;
							$("input[name=costo_repuesto]").parent().addClass("has-error has-feedback");
						}

						if(is_correct){							
				        	$.ajax({
								url: inside_url+'mant_correctivo/submit_create_repuesto_ajax',
								type: 'POST',
								data: { 
									'idot_correctivo' : $("input[name=idot_correctivo]").val(),
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
									$("input[name=nombre_repuesto]").val("");
									$("input[name=codigo_repuesto]").val("");
									$("input[name=cantidad_repuesto]").val("");
									$("input[name=costo_repuesto]").val("");
								},
								success: function(response){
									var str = "";
									str += '<tr id="repuesto-row-'+response.repuesto.idrepuestos_ot_correctivo+'"><td  class=\"text-nowrap\">'+response.repuesto.nombre+'</td>';
									str += "<td class=\"text-nowrap text-center\">"+response.repuesto.codigo+"</td>";
									str += "<td class=\"text-nowrap text-center\">"+response.repuesto.cantidad+"</td>";
									str += "<td class=\"text-nowrap text-center\">S/. "+response.repuesto.costo+"</td>";
									str += '<td class=\"text-nowrap text-center\"><button class="btn btn-danger boton-eliminar-repuesto" onclick="eliminar_repuesto(event,'+response.repuesto.idrepuestos_ot_correctivo+')" type="button"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
									$("#repuestos-table").append(str);
									$("input[name=costo_total_repuestos]").val(response.costo_total_repuestos);
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
					var reg = /[^á-úÁ-Úa-zA]+$/;
					var floatRegex = /^\d{1,6}(\.\d{0,2}){0,1}$/;
					var is_correct = true;
					$("input[name=nombre_personal]").parent().removeClass("has-error has-feedback");
					$("input[name=horas_trabajadas]").parent().removeClass("has-error has-feedback");
					$("input[name=costo_personal]").parent().removeClass("has-error has-feedback");
					if(reg.test($("input[name=nombre_personal]").val())){
						error_str += "El nombre debe ser alfabético\n";
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
							url: inside_url+'mant_correctivo/submit_create_personal_ajax',
							type: 'POST',
							data: { 
								'idot_correctivo' : $("input[name=idot_correctivo]").val(),
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

	$('#submit-edit').click(function(){
		BootstrapDialog.confirm({
		title: 'Mensaje de Confirmación',
		message: '¿Está seguro que desea realizar esta acción?\n (Si el campo "Equipo no Intervenido" no se encuentra en estado pendiente, la presente ficha no podrá volver a ser editada)', 
		type: BootstrapDialog.TYPE_INFO,
		btnCancelLabel: 'Cancelar', 
    	btnOKLabel: 'Aceptar', 
			callback: function(result){
		        if(result) {
		        	document.getElementById('submit_ot_correctivo').submit();
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
						url: inside_url+'mant_correctivo/submit_delete_tarea_ajax',
						type: 'POST',
						data: { 
							'idtareas_ot_correctivo' : id,
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

function eliminar_repuesto(e,id){
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
						url: inside_url+'mant_correctivo/submit_delete_repuesto_ajax',
						type: 'POST',
						data: { 
							'idot_correctivo' : $("input[name=idot_correctivo]").val(),
							'idrepuestos_ot_correctivo' : id,
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
						url: inside_url+'mant_correctivo/submit_delete_personal_ajax',
						type: 'POST',
						data: { 
							'idot_correctivo' : $("input[name=idot_correctivo]").val(),
							'idpersonal_ot_correctivo' : id,
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

function init_ot_correctivo(){
	
	if($("#fecha_conformidad").length){
		$("#fecha_conformidad").datetimepicker({
	            defaultDate: false,
	            ignoreReadonly: true,
	            format: 'DD-MM-YYYY HH:mm',
	            sideBySide: true
	    });

	    $("#fecha_conformidad").on("dp.change", function (e) {
	        $('#fecha_conformidad').data("DateTimePicker").minDate(e.date);
	    });
	}

	if($('.fecha-hora').length){
		$(".fecha-hora").datetimepicker({
	            defaultDate: false,
	            ignoreReadonly: true,
	            format: 'DD-MM-YYYY HH:mm',
	            sideBySide: true
	    });

	    
	}

}