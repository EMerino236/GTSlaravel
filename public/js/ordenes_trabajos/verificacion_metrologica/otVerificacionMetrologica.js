$( document ).ready(function(){
	
	init_ot_create();

	$('#submit_ot').click(function(){
		BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?\n (Si el campo "Equipo no Intervenido" no se encuentra en estado pendiente, la presente ficha no podrá volver a ser editada)', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
				callback: function(result){
			        if(result) {
			        	document.getElementById('submit_ot_metrologica').submit();
			        }
			    }
		});
	})

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
								url: inside_url+'verif_metrologica/submit_create_personal_ajax',
								type: 'POST',
								data: { 
									'idot_vmetrologica' : $("input[name=idot_vmetrologica]").val(),
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
									str += '<tr id="personal-row-'+response.personal.idpersonal_ot_vmetrologica+'"><td class="text-nowrap">'+response.personal.nombre+'</td>';
									str += "<td class=\"text-nowrap text-center\">"+response.personal.horas_hombre+"</td>";
									str += "<td class=\"text-nowrap text-center\">S/. "+response.personal.costo+"</td>";
									str += '<td class=\"text-nowrap text-center\"><button class="btn btn-danger boton-eliminar-personal" onclick="eliminar_personal(event,'+response.personal.idpersonal_ot_vmetrologica+')" type="button"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
									$("#personal-table").append(str);
									$("input[name=costo_total_personal]").val(response.costo_total);
									$("input[name=nombre_personal]").val('');
									$("input[name=horas_trabajadas]").val('');
									$("input[name=costo_personal]").val('');
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
});


function init_ot_create(){
	array_fecha = $('#fecha_programacion_ot').val().split('-');
	fecha_str = array_fecha[2]+"-"+array_fecha[1]+"-"+array_fecha[0];
	$("#datetimepicker_conformidad_fecha").datetimepicker({
		useCurrent:false,
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
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
				callback: function(result){
					if(result){
						$.ajax({
							url: inside_url+'verif_metrologica/submit_delete_personal_ajax',
							type: 'POST',
							data: { 
								'idot_vmetrologica' : $("input[name=idot_vmetrologica]").val(),
								'idpersonal_ot_vmetrologica' : id,
							},
							beforeSend: function(){
								//$(this).prop('disabled',true);
							},
							complete: function(){
								//$(this).prop('disabled',false);
							},
							success: function(response){
								$("#personal-row-"+id).remove();
								$("input[name=costo_total_personal]").val(response.costo_total);
							},
							error: function(){
							}
						});
					}
				}
	});
}

function llenar_nombre_doc_relacionado(id){
        var val = $("#num_doc_relacionado"+id).val();
        if(val=="")
            return;    
        $.ajax({
            url: inside_url+'verif_metrologica/return_name_doc_relacionado/'+val,
            type: 'POST',
            data: { 'selected_id' : val },
            beforeSend: function(){
                $("#delete-selected-profiles").addClass("disabled");
                $("#delete-selected-profiles").hide();
                $(".loader_container").show();
            },
            complete: function(){
                $(".loader_container").hide();
                $("#delete-selected-profiles").removeClass("disabled");
                $("#delete-selected-profiles").show();
                delete_selected_profiles = true;
            },
            success: function(response){
                if(response.success){
                    var resp = response['contrato'];
                    if(resp != null){
                    	var otm = response['ot'];
                    	if(otm == null){
                    		$("#nombre_doc_relacionado"+id).val("");
	                        $("#nombre_doc_relacionado"+id).css('background-color','#5cb85c');
	                        $("#nombre_doc_relacionado"+id).css('color','white');
	                        $("#nombre_doc_relacionado"+id).val(resp.nombre); 
	                        $("#documento_url").attr("href", inside_url+"verif_metrologica/download_documento/"+resp.iddocumento);                          
	                    	$("#documento_url").css('visibility','visible');
                    	 	$("#num_doc_relacionado"+id).prop('readonly',true);
                    	}else{
                    		$("#nombre_doc_relacionado"+id).val("Documento ya fue tomado");
	                        $("#nombre_doc_relacionado"+id).css('background-color','#d9534f');
	                        $("#nombre_doc_relacionado"+id).css('color','white');
	                        $("#documento_url").css('visibility','hidden');
	                        $("#num_doc_relacionado"+id).prop('readonly',false);
                    	}                        
                    }else{
                        $("#nombre_doc_relacionado"+id).val("Documento no registrado");
                        $("#nombre_doc_relacionado"+id).css('background-color','#d9534f');
                        $("#nombre_doc_relacionado"+id).css('color','white');
                        $("#documento_url").css('visibility','hidden');
                    	$("#num_doc_relacionado"+id).prop('readonly',false);
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

function limpiar_nombre_doc_relacionado(id){
    $("#nombre_doc_relacionado"+id).val("");
    $("#num_doc_relacionado"+id).val("");
    $("#nombre_doc_relacionado"+id).css('background-color','white');
    $("#documento_url").css('visibility','hidden');
    $("#num_doc_relacionado"+id).prop('readonly',false);
}