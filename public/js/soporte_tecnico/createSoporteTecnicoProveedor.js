$( document ).ready(function(){

 	$('.btnEliminarSoporteTecnicoProveedor').click(function(){
		var idsoporte_tecnico = $(this).attr('data-value');
		
		$('#modal_delete_soporte_tecnico_proveedor').modal('toggle');
		$('.modal_btnEliminarSoporteTecnicoProveedor').attr('data-value',idsoporte_tecnico);
	});

	$('.modal_btnEliminarSoporteTecnicoProveedor').click(function(){
		var idsoporte_tecnico = $(this).attr('data-value');		
		
		submit_delete_soporte_tecnico_proveedor_ajax(idsoporte_tecnico);
	});

	$('#tipo_documento_identidad').change(function(){
		val = $('#tipo_documento_identidad').val();
		if(val == 0){
			$('#numero_documento_soporte_tecnico').attr('maxlength','12');
		}else if(val == 1){
			$('#numero_documento_soporte_tecnico').attr('maxlength','8');
		}else{
			$('#numero_documento_soporte_tecnico').attr('maxlength','12');
		}
		
	});

});

function submit_delete_soporte_tecnico_proveedor_ajax(idsoporte_tecnico)
{	
	$.ajax({
	    url: inside_url+'proveedores/submit_delete_soporte_tecnico_proveedor_ajax',
	    type: 'POST',
	    data: {'idsoporte_tecnico': idsoporte_tecnico },
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
	        if(response.success)
	        {    
	         	location.reload();
	        }
	        else
	        {
            	alert('La petición no se pudo completar, inténtelo de nuevo.');
	        }
	    },
	    error: function(){
	        alert('La petición no se pudo completar, inténtelo de nuevo.');
		}
	});
}