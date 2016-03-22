function limpiarCriteriosPresupuesto()
{
    $("#search_nombre_capacitacion").val("");
    $("#search_responsable_capacitacion").val("");
    $("#search_departamento_capacitacion").val("");
    $("#search_servicio_capacitacion").val("");
    $("#fecha_ini_capacitacion").val("");
    $("#fecha_fin_capacitacion").val("");
}

function habilitaCampos(){
	var valor = $('#tipo_capacitacion :selected').val();

	if(valor == 1 || valor == 2){
		$('#collapseCampos').slideDown();
	}else{
		$('#collapseCampos').slideUp();
		limpiaCollapseCampos();
	}
	
}

function limpiaCollapseCampos(){
	$('#codigo_patrimonial').val('');
	$('#equipo_relacionado').val('');
}

function limpiarPersonalExterno(){
	$('#nombre').val(null);
	$('#descripcion_personal').val(null);
	$('#rol').val(null);
	$('#institucion').val(null);
}

function agregarPersonalInvolucrado(){
	var error_str = "";
	var reg = /[^á-úÁ-Úa-zA-ZñÑüÜ _]/;
	var is_correct = true;

	$("input[name=nombre]").parent().removeClass("has-error has-feedback");
	$("input[name=descripcion_personal]").parent().removeClass("has-error has-feedback");
	$("input[name=rol]").parent().removeClass("has-error has-feedback");
	$("input[name=institucion]").parent().removeClass("has-error has-feedback");
	
	if(reg.test($("input[name=nombre]").val())){
		error_str += "El nombre no debe tener caracteres especiales ni números.\n";
		$("input[name=nombre]").parent().addClass("has-error has-feedback");
		is_correct = false;
	}
	if($("input[name=nombre]").val().length < 1 || $("input[name=nombre]").val().length > 100){
		error_str += "El nombre es obligatorio y debe contener menos de 100 caracteres\n";
		$("input[name=nombre]").parent().addClass("has-error has-feedback");
		is_correct = false;
	}

	if(reg.test($("input[name=descripcion_personal]").val())){
		error_str += "La descripción no debe tener caracteres especiales ni números.\n";
		is_correct = false;
		$("input[name=descripcion_personal]").parent().addClass("has-error has-feedback");
	}
	if($("input[name=descripcion_personal]").val().length < 1 || $("input[name=descripcion_personal]").val().length > 100){
		error_str += "La descripción es obligatoriay debe contener menos de 100 caracteres.\n";
		is_correct = false;
		$("input[name=descripcion_personal]").parent().addClass("has-error has-feedback");
	}

	if(reg.test($("input[name=rol]").val())){
		error_str += "El rol no debe tener caracteres especiales ni números.\n";
		is_correct = false;
		$("input[name=rol]").parent().addClass("has-error has-feedback");
	}
	if($("input[name=rol]").val().length < 1 || $("input[name=rol]").val().length > 100){
		error_str += "El rol es obligatorio y debe contener menos de 100 caracteres.\n";
		is_correct = false;
		$("input[name=rol]").parent().addClass("has-error has-feedback");
	}

	if(reg.test($("input[name=institucion]").val())){
		error_str += "La institucion no debe tener caracteres especiales ni números.\n";
		is_correct = false;
		$("input[name=institucion]").parent().addClass("has-error has-feedback");
	}
	if($("input[name=institucion]").val().length < 1 || $("input[name=institucion]").val().length > 100){
		error_str += "La institucion es obligatorio y debe contener menos de 100 caracteres.\n";
		is_correct = false;
		$("input[name=institucion]").parent().addClass("has-error has-feedback");
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
	        		nombre = $('#nombre').val();
	        		descripcion = $('#descripcion_personal').val();
	        		rol = $('#rol').val();
	        		institucion = $('#institucion').val();

	        		var str = "<tr><td class=\"text-nowrap\"><input style=\"border:0\" name='details_nombre[]' value='"+nombre+"' readonly/></td>";
                    str += "<td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='details_descripcion[]' value='"+descripcion+"' readonly/></td>";
                    str += "<td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='details_rol[]' value='"+rol+"' readonly/></td>";
                    str += "<td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='details_institucion[]' value='"+institucion+"' readonly/></td>";
                    str += "<td class=\"text-nowrap text-center\"><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-trash\"></span></a></td></tr>";
                    $("table").append(str);
	        		
	        	}
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

function buscarEquipo(){
	codigo = $('#codigo_patrimonial').val();
	if(codigo.length==0){
		$("#equipo_relacionado").val('');         
		return;
	}		
	else{
		$.ajax({
	        url: inside_url+'capacitacion/search_equipo_ajax',
	        type: 'POST',
	        data: { 'selected_id' : codigo,
	            },
	        beforeSend: function(){
	            $(".loader_container").show();
	        },
	        complete: function(){
	            $(".loader_container").hide();
	        },
	        success: function(response){
	            if(response.success){
	            	var equipo = response['equipo'];
	                if(equipo != null){
	                    $("#equipo_relacionado").val("");
	                    $("#equipo_relacionado").val(equipo.nombre_equipo);
	                }
	                else{                        
	                    $("#equipo_relacionado").val('');                       
	                }
	            }else{
	                alert('La petición no se pudo completar, inténtelo de nuevo.');
	            }
	        },
	        error: function(){
	            alert('La petición no se pudo completar, inténtelo de nuevo.');
	        }
	    });
	}
}

function eliminar_personal(e,id_personal){
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
				        url: inside_url+'capacitacion/eliminar_personal_ajax',
				        type: 'POST',
				        data: { 'selected_id' : id_personal,
				            },
				        beforeSend: function(){
				            $(".loader_container").show();
				        },
				        complete: function(){
				            $(".loader_container").hide();
				        },
				        success: function(response){
				            if(response.success){
				            	if(response["exito"]== 1 )
				            	   	location.reload();
				            	else{
				            		dialog = BootstrapDialog.show({
						            title: 'Advertencia',
						            message: 'Error',
						            type : BootstrapDialog.TYPE_DANGER,
						            buttons: [{
						                label: 'Aceptar',
						                action: function(dialog) {
						                    dialog.close();
						                }
						            }]
						        });    
				            	}
				            }else{
				                alert('La petición no se pudo completar, inténtelo de nuevo.');
				            }
				        },
				        error: function(){
				            alert('La petición no se pudo completar, inténtelo de nuevo.');
				        }
				    });
	        	}
	        }
	});
}

function eliminar_actividad(e,id_actividad){
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
				        url: inside_url+'capacitacion/eliminar_actividad_ajax',
				        type: 'POST',
				        data: { 'selected_id' : id_actividad,
				            },
				        beforeSend: function(){
				            $(".loader_container").show();
				        },
				        complete: function(){
				            $(".loader_container").hide();
				        },
				        success: function(response){
				            if(response.success){
				            	if(response["exito"]== 1 )
				            	   	location.reload();
				            	else{
				            		dialog = BootstrapDialog.show({
						            title: 'Advertencia',
						            message: 'Error',
						            type : BootstrapDialog.TYPE_DANGER,
						            buttons: [{
						                label: 'Aceptar',
						                action: function(dialog) {
						                    dialog.close();
						                }
						            }]
						        });    
				            	}
				            }else{
				                alert('La petición no se pudo completar, inténtelo de nuevo.');
				            }
				        },
				        error: function(){
				            alert('La petición no se pudo completar, inténtelo de nuevo.');
				        }
				    });
	        	}
	        }
	});
}

function eliminar_competencia(e,id_competencia){
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
				        url: inside_url+'capacitacion/eliminar_competencia_ajax',
				        type: 'POST',
				        data: { 'selected_id' : id_competencia,
				            },
				        beforeSend: function(){
				            $(".loader_container").show();
				        },
				        complete: function(){
				            $(".loader_container").hide();
				        },
				        success: function(response){
				            if(response.success){
				            	if(response["exito"]== 1 )
				            	   	location.reload();
				            	else{
				            		dialog = BootstrapDialog.show({
						            title: 'Advertencia',
						            message: 'Error',
						            type : BootstrapDialog.TYPE_DANGER,
						            buttons: [{
						                label: 'Aceptar',
						                action: function(dialog) {
						                    dialog.close();
						                }
						            }]
						        });    
				            	}
				            }else{
				                alert('La petición no se pudo completar, inténtelo de nuevo.');
				            }
				        },
				        error: function(){
				            alert('La petición no se pudo completar, inténtelo de nuevo.');
				        }
				    });
	        	}
	        }
	});
}

function showAdjuntarCertificado()
{
		$("#adjuntar_certificado").toggle();
		$('#input-file').fileinput('clear');   
	
}