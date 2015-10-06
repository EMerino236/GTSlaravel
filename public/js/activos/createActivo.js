$( document ).ready(function(){
 	$('#ubicacion_fisica').prop('disabled',true);
 	$('#nombre_equipo').prop('disabled',true);
 	$('#modelo').prop('disabled',true);

 	$('#servicio_clinico').change(function(){
 		search_create_ubicacion_ajax();
 	});

 	$('#marca').change(function(){
 		search_nombre_equipo_ajax();
 	});

 	$('#nombre_equipo').change(function(){
 		fill_modelo();
 	});

});

function search_create_ubicacion_ajax(){

	var val = $("#servicio_clinico").val();	

	$.ajax({
	    url: inside_url+'/equipos/search_create_ubicacion_ajax',
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
	            var select = $('#ubicacion_fisica');
	        	select.empty().append('<option value="">Seleccione</option>');

	            var ubicaciones = response['ubicacion'];
	            var size = ubicaciones.length;

	            if(size != 0)
	            {					
					$.each(ubicaciones, function(index,value) {
						var option = "<option value=" + ubicaciones[index].idubicacion_fisica + ">" +ubicaciones[index].nombre + "</option>";
				    	select.append(option);
					});

	            	select.prop('disabled',false);
	            }
	            else
	            {	            	
	            	select.prop('disabled',true);
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

var nombre_equipo;
function search_nombre_equipo_ajax(){

	var val = $('#marca').val();

	$.ajax({
	    url: inside_url + '/equipos/search_nombre_equipo_ajax',
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
	            var select = $('#nombre_equipo');
	        	select.empty().append('<option value="">Seleccione</option>');

	            nombre_equipo = response['nombre_equipo'];
	            var size = nombre_equipo.length;

	            if(size != 0)
	            {					
					$.each(nombre_equipo, function(index,value) {
						var option = "<option value=" + nombre_equipo[index].idfamilia_activo + ">" +nombre_equipo[index].nombre_equipo + " - " + nombre_equipo[index].modelo + "</option>";
				    	select.append(option);
					});

	            	select.prop('disabled',false);
	            }
	            else
	            {	            	
	            	select.prop('disabled',true);
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

function fill_modelo(){
	
	var val_selected = $('#nombre_equipo').prop('selectedIndex');

 		if(val_selected == 0){
 			$('#modelo').val("");
 		}else{
 			$('#modelo').val(nombre_equipo[val_selected - 1].modelo);
 		}

};