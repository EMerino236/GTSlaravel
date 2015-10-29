$( document ).ready(function(){
 	
 	init();

 	$('#tipo_documento_identidad_activo').change(function(){
 		edit_numero_documento();
 	});

 	$('#btnBuscarSoporteTecnico').click(function(){
		search_soporte_tecnico_ajax();
 	});

 	$('#btnLimpiar_agregar_soporte_tecnico').click(function(){
 		limpiar_criterios();
 	});

});

function init()
{
	var idtipo_documento = $('#tipo_documento_identidad_activo').val()

	if(idtipo_documento == ''){
		$('#numero_documento_soporte_tecnico_activo').prop('disabled',true);
	}else{
		$('#numero_documento_soporte_tecnico_activo').prop('disabled',false);
	}
}

function edit_numero_documento()
{
	var idtipo_documento = $('#tipo_documento_identidad_activo').val();

	if(idtipo_documento == ''){
		$('#numero_documento_soporte_tecnico_activo').prop('disabled',true);
		$('#numero_documento_soporte_tecnico_activo').val("");
	}else{
		$('#numero_documento_soporte_tecnico_activo').prop('disabled',false);
	}
}

function limpiar_criterios()
{
	$('#tipo_documento_identidad_activo').prop('selectedIndex',0);
	$('#numero_documento_soporte_tecnico_activo').prop('disabled',true);
	$('#numero_documento_soporte_tecnico_activo').val("");
	$('#nombre_soporte_tecnico_activo').val("");
	$('#apPaterno_soporte_tecnico_activo').val("");
	$('#apMaterno_soporte_tecnico_activo').val("");
	$('#especialidad_soporte_tecnico_activo').val("");
	$('#telefono_soporte_tecnico_activo').val("");
	$('#email_soporte_tecnico_activo').val("");
	$('#mensaje_validacion_soporte_tecnico_activo').val("");
	$("#mensaje_validacion_soporte_tecnico_activo").css('background-color','#eee');
	$("#mensaje_validacion_soporte_tecnico_activo").css('color','#555');
}

function search_soporte_tecnico_ajax()
{
	var idtipo_documento = $('#tipo_documento_identidad_activo').val();
	var numero_documento_identidad = $('#numero_documento_soporte_tecnico_activo').val();

	if(idtipo_documento != "" && numero_documento_identidad!= "")
	{
		$.ajax({
		    url: inside_url+'equipos/search_soporte_tecnico_ajax',
		    type: 'POST',
		    data: { 'idtipo_documento' : idtipo_documento, 'numero_documento_identidad' : numero_documento_identidad },
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
		        	var resp = response["data"][0];
		        	console.log(resp);		        	
		            if(resp != null){
		            	$('input[name=idsoporte_tecnico]').val(resp.idsoporte_tecnico);		            	
		            	$('#nombre_soporte_tecnico_activo').val(resp.nombres);
		            	$('#apPaterno_soporte_tecnico_activo').val(resp.apellido_pat);
		            	$('#apMaterno_soporte_tecnico_activo').val(resp.apellido_mat);
		            	$('#proveedor_soporte_tecnico_activo').val(resp.proveedor);
		            	$('#especialidad_soporte_tecnico_activo').val(resp.especialidad);
		            	$('#telefono_soporte_tecnico_activo').val(resp.telefono);
		            	$('#email_soporte_tecnico_activo').val(resp.email);

		            	$("#mensaje_validacion_soporte_tecnico_activo").css('background-color','#5cb85c');
	                    $("#mensaje_validacion_soporte_tecnico_activo").css('color','white');
	                    $('#mensaje_validacion_soporte_tecnico_activo').val('Usuario Registrado');             
	                              
		            }else{
		                $('#mensaje_validacion_soporte_tecnico_activo').val('Usuario No Registrado');
		                $("#mensaje_validacion_soporte_tecnico_activo").css('background-color','#d9534f');
		                $("#mensaje_validacion_soporte_tecnico_activo").css('color','white');		                
		            }		            
		        }else{
		            alert('La petición no se pudo completar, inténtelo de nuevo.');
		        }
		    },
		    error: function(){
		        alert('La petición no se pudo completar, inténtelo de nuevo. FATAL');
		    }
		});
	}
}