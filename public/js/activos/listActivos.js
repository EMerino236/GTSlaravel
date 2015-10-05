$( document ).ready(function(){
 	
 	init();

 	$('#search_servicio').change(function(){
 		search_ubicacion_ajax();
 	});

 	$('#btnLimpiar').click(function(){
 		limpiar_criterios();
 	});
});

function init(){

	var val = $('#search_servicio').val();

	if(val == '0'){
		//$('#search_ubicacion').attr('disabled',true);
	}else{
		search_ubicacion_ajax();
	}
}

function limpiar_criterios(){

	$('#search_grupo').prop('selectedIndex','0');
	$('#search_servicio').prop('selectedIndex','0');
	$('#search_ubicacion').prop('selectedIndex','0');
	$('#search_marca').prop('selectedIndex','0');
	$('#search_proveedor').prop('selectedIndex','0');

	$('#search_nombre_equipo').val("");
	$('#search_modelo').val("");
	$('#search_serie').val("");
	$('#search_codigo_compra').val("");
	$('#search_codigo_patrimonial').val("");
};

function search_ubicacion_ajax(){

	var val = $("#search_servicio").val();	

	$.ajax({
	    url: inside_url+'/equipos/search_ubicacion_ajax',
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
	        if(response.success)
	        {
	            var select = $('#search_ubicacion');
	        	select.empty().append('<option value="0">Seleccione</option>');

	            var ubicaciones = response['ubicacion'];
	            var size = ubicaciones.length;

	            if(size != 0)
	            {					
					$.each(ubicaciones, function(index,value) {
						var option = "<option value=" + ubicaciones[index].idubicacion_fisica + ">" +ubicaciones[index].nombre + "</option>";
				    	select.append(option);
					});

	            	//select.attr('disabled',false);
	            }
	            else
	            {	            	
	            	//select.attr('disabled',true);
	            }
	            
	        }
	        else
	        {
            	alert('La petición no se pudo completar, inténtelo de nuevo. asdasd');
	        }
	    },
	    error: function(){
	        alert('La petición no se pudo completar, inténtelo de nuevo.');
		}
	});
};