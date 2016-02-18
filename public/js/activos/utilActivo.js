$( document ).ready(function(){

	$("#datetimepicker1").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker2").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	init_utilActivo();

 	$('#marca').change(function(){
 		search_nombre_equipo_ajax();
 	});

 	$('#nombre_equipo').change(function(){
 		search_modelo_equipo_ajax();
 	});

});

function init_utilActivo(){
	
	var val_marca = $('#marca').val();
	var val_modelo = $('#modelo').val();	

	if(val_marca == ''){
		$('#nombre_equipo').prop('disabled',true);
	}else{
		$('#nombre_equipo').prop('disabled',false);
		search_nombre_equipo_ajax();
	}

	if(val_modelo == ''){
		$('#modelo').prop('disabled',true);
	}else{
		$('#modelo').prop('disabled',false);
	}
}

var nombre_equipo;
function search_nombre_equipo_ajax()
{
	var val = $('#marca').val();

	$.ajax({
	    url: inside_url + 'equipos/search_nombre_equipo_ajax',
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
						var option = "<option value=" + nombre_equipo[index].idfamilia_activo + ">" +nombre_equipo[index].nombre_equipo + "</option>";
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

function search_modelo_equipo_ajax()
{
	var val = $('#nombre_equipo').val();

	$.ajax({
	    url: inside_url + 'equipos/search_modelo_equipo_ajax',
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
	            var select = $('#modelo');
	        	select.empty().append('<option value="">Seleccione</option>');

	            modelo_equipo = response['modelo_equipo'];
	            var size = modelo_equipo.length;

	            if(size != 0)
	            {					
					$.each(modelo_equipo, function(index,value) {
						var option = "<option value=" + modelo_equipo[index].idmodelo_equipo + ">" + modelo_equipo[index].nombre + "</option>";
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
}

function fill_modelo()
{
	
	var val_selected = $('#nombre_equipo').prop('selectedIndex');

 		if(val_selected == 0){
 			$('#modelo').val("");
 		}else{
 			$('#modelo').val(nombre_equipo[val_selected - 1].modelo);
 		}
};