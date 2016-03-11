$( document ).ready(function(){ 

	$("#adjuntar_plan_difusion").hide();

	
	$('#modalDeletePlanDifusion').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var value = button.data('value') // Extract info from data-* attributes
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.	  
	  var modal = $(this)
	  modal.find('#id_plan_difusion').val(value);  
	});

	$("#datetimepicker_create_plan_difusion_ini").on("dp.change", function (e) {
        $('#datetimepicker_create_plan_difusion_fin').data("DateTimePicker").minDate(e.date);
    });
    
    $("#datetimepicker_create_plan_difusion_fin").on("dp.change", function (e) {
        $('#datetimepicker_create_plan_difusion_ini').data("DateTimePicker").maxDate(e.date);
    });

});

function limpiarCriteriosPlanDifusion()
{
    $("#search_nombre_plan_difusion").val("");
    $("#search_responsable_plan_difusion").val("");
    $("#search_departamento_plan_difusion").prop('selectedIndex','0');
    $('#search_servicio_plan_difusion').empty().append('<option value="">Seleccione</option>');
    $('#search_servicio_plan_difusion').prop('selectedIndex','0');
    $('#fecha_ini_plan_difusion').val("");
    $('#fecha_fin_plan_difusion').val("");
}

function limpiarResponsableData()
{
	$('#responsable_planteamiento_difusion').val("");
	$('#responsable_planteamiento_difusion').css('background-color','#eee');
	$('#responsable_planteamiento_difusion').css('color','#555');	            	
	$('#dni_responsable_planteamiento_difusion').val("");
	$('#responsable_planteamiento_difusion').val("");
	$('#idresponsable').val("");

}

function showAdjuntarPlanDifusion()
{
	$("#adjuntar_plan_difusion").toggle();
}


function getServiciosIndexAjax()
{
	var val = $('#search_departamento_plan_difusion').val();

	$.ajax({
	    url: inside_url + 'planteamiento_difusion/getServiciosAjax',
	    type: 'POST',
	    data: { 'value' : val },
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
	            var obj = $('#search_servicio_plan_difusion');
	        	obj.empty().append('<option value="">Seleccione</option>');

	            servicios = response['servicios'];
	            var size = servicios.length;
	            
				$.each(servicios, function(index,value) {
					var option = "<option value=" + servicios[index].idservicio + ">" +servicios[index].nombre + "</option>";
			    	obj.append(option);
				});            
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

function getServiciosCreateAjax()
{
	var val = $('#departamento_planteamiento_difusion').val();

	$.ajax({
	    url: inside_url + 'planteamiento_difusion/getServiciosAjax',
	    type: 'POST',
	    data: { 'value' : val },
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
	            var obj = $('#servicio_planteamiento_difusion');
	        	obj.empty().append('<option value="">Seleccione</option>');

	            servicios = response['servicios'];
	            var size = servicios.length;
	            
				$.each(servicios, function(index,value) {
					var option = "<option value=" + servicios[index].idservicio + ">" +servicios[index].nombre + "</option>";
			    	obj.append(option);
				});            
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

function getUserCreateAjax()
{
	var val = $('#dni_responsable_planteamiento_difusion').val();

	$.ajax({
	    url: inside_url + 'planteamiento_difusion/getUserAjax',
	    type: 'POST',
	    data: { 'value' : val },
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
	           	var obj1 = $('#responsable_planteamiento_difusion');
	            var obj2 = $('#idresponsable');
	            var user = response['user'][0];

	            if(user == null)
	            {
	            	obj1.val("El número de documento no existe");
	                obj1.css('background-color','#d9534f');
	                obj1.css('color','white');
	            }else
	            {
	            	obj1.val("");
					obj1.css('background-color','#eee');
    				obj1.css('color','#555');	            	
	            	var nombre = user.apellido_pat + " " + user.apellido_mat + ", " + user.nombre
	            	obj1.val(nombre);
	            	obj2.val(user.id);
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